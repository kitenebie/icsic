<!DOCTYPE html>
<html>
<head>
  <title>Live WebRTC Video Call with Firebase</title>
  <style>
    video {
      width: 45%;
      border: 2px solid #555;
      border-radius: 8px;
      margin: 10px;
    }
  </style>
</head>
<body>
  <h2>🔴 Live WebRTC Video Call</h2>

  <button onclick="createCall()">📞 Create Call</button>
  <input id="callIdInput" placeholder="Enter Call ID">
  <button onclick="joinCall()">✅ Join Call</button>
  <button onclick="hangUp()">🔕 Hang Up</button>

  <h3>📷 Local Video:</h3>
  <video id="localVideo" autoplay muted playsinline></video>

  <h3>📡 Remote Video:</h3>
  <video id="remoteVideo" autoplay playsinline></video>

  <!-- Firebase SDKs -->
  <script src="https://www.gstatic.com/firebasejs/10.5.2/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.5.2/firebase-database-compat.js"></script>

  <script>
    const firebaseConfig = {
      apiKey: "AIzaSyBomSVQcMytesRLPUZgz9I-MVuQt5yEKCQ",
      authDomain: "fb1-tst.firebaseapp.com",
      databaseURL: "https://fb1-tst-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "fb1-tst",
      storageBucket: "fb1-tst.appspot.com",
      messagingSenderId: "426139628396",
      appId: "1:426139628396:web:52ec020c8d45e26c53b949"
    };

    firebase.initializeApp(firebaseConfig);
    const db = firebase.database();

    const servers = {
      iceServers: [{ urls: "stun:stun.l.google.com:19302" }]
    };

    let localStream, peerConnection, callRef;

    async function getMedia() {
      // Browser support check
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert("Your browser does not support WebRTC or camera access.");
        throw new Error("getUserMedia not supported");
      }

      try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        document.getElementById("localVideo").srcObject = localStream;
      } catch (err) {
        alert("Failed to access camera/microphone: " + err.message);
        throw err;
      }
    }

    async function createCall() {
      await getMedia();

      const callId = Math.random().toString(36).substring(2, 10);
      document.getElementById("callIdInput").value = callId;

      callRef = db.ref(`calls/${callId}`);
      const offerCandidates = callRef.child("offerCandidates");
      const answerCandidates = callRef.child("answerCandidates");

      peerConnection = new RTCPeerConnection(servers);
      localStream.getTracks().forEach(track => {
        peerConnection.addTrack(track, localStream);
      });

      peerConnection.onicecandidate = event => {
        if (event.candidate) {
          offerCandidates.push(event.candidate.toJSON());
        }
      };

      peerConnection.ontrack = event => {
        document.getElementById("remoteVideo").srcObject = event.streams[0];
      };

      const offer = await peerConnection.createOffer();
      await peerConnection.setLocalDescription(offer);
      await callRef.set({ offer });

      callRef.child("answer").on("value", async snapshot => {
        const answer = snapshot.val();
        if (answer && !peerConnection.currentRemoteDescription) {
          await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
        }
      });

      answerCandidates.on("child_added", snapshot => {
        const candidate = new RTCIceCandidate(snapshot.val());
        peerConnection.addIceCandidate(candidate);
      });
    }

    async function joinCall() {
      const callId = document.getElementById("callIdInput").value;
      if (!callId) {
        alert("Please enter a Call ID to join.");
        return;
      }

      await getMedia();
      callRef = db.ref(`calls/${callId}`);

      peerConnection = new RTCPeerConnection(servers);
      localStream.getTracks().forEach(track => {
        peerConnection.addTrack(track, localStream);
      });

      const offerCandidates = callRef.child("offerCandidates");
      const answerCandidates = callRef.child("answerCandidates");

      peerConnection.onicecandidate = event => {
        if (event.candidate) {
          answerCandidates.push(event.candidate.toJSON());
        }
      };

      peerConnection.ontrack = event => {
        document.getElementById("remoteVideo").srcObject = event.streams[0];
      };

      const offerSnapshot = await callRef.child("offer").once("value");
      const offer = offerSnapshot.val();

      if (!offer) {
        alert("Call not found.");
        return;
      }

      await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));
      const answer = await peerConnection.createAnswer();
      await peerConnection.setLocalDescription(answer);
      await callRef.child("answer").set(answer);

      offerCandidates.on("child_added", snapshot => {
        const candidate = new RTCIceCandidate(snapshot.val());
        peerConnection.addIceCandidate(candidate);
      });
    }

    function hangUp() {
      if (peerConnection) peerConnection.close();
      if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
      }
      document.getElementById("localVideo").srcObject = null;
      document.getElementById("remoteVideo").srcObject = null;
      alert("Call ended.");
    }
  </script>
</body>
</html>
