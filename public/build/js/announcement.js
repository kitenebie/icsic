
document.addEventListener("DOMContentLoaded", () => {
    const likeButtons = document.querySelectorAll('[aria-label="Like button with reactions"]');
    const topIcons = document.querySelectorAll('#like-icon-post1');
    
    const reactionImages = {
        like:  '/build/img/like.png',
        love:  '/build/img/love.png',
        haha:  '/build/img/haha.png',
        care:  '/build/img/care.png',
        wow:   '/build/img/wow.png',
        sad:   '/build/img/sad.png',
        angry: '/build/img/angry.png'
    };
    
    likeButtons.forEach((button) => {
        const popup = button.querySelector(".reaction-popup");
        const displayImg = button.querySelector("img#like-icon-post");
        const defaultIcon = button.querySelector("i#like-icon-post1");
    
        let currentReaction = null;
        let popupVisible = false;
    
        // Toggle popup on click (for mobile)
        button.addEventListener("click", (e) => {
            // Don't react if already clicked a reaction (stop bubbling)
            if (e.target.closest('.reaction-popup img')) return;
    
            popupVisible = !popupVisible;
            popup.classList.toggle("show", popupVisible);
        });
    
        // Optional: close popup when clicking outside
        document.addEventListener("click", (e) => {
            if (!button.contains(e.target)) {
                popupVisible = false;
                popup.classList.remove("show");
            }
        });
      // Show popup on hover
      button.addEventListener("mouseenter", () => {
        popup.classList.add("show");
    });

    button.addEventListener("mouseleave", () => {
        popup.classList.remove("show");
    });
        // Handle reaction clicks
        const reactions = popup.querySelectorAll("img[data-reaction]");
        reactions.forEach((reaction) => {
            reaction.addEventListener("click", (e) => {
                const type = e.target.getAttribute("data-reaction");
    
                if (!reactionImages[type]) return;
    
                if (currentReaction === type) {
                    // Toggle off
                    currentReaction = null;
                    displayImg.classList.add("hidden");
                    defaultIcon.classList.remove("hidden");
                } else {
                    // Set new reaction
                    currentReaction = type;
                    displayImg.src = reactionImages[type];
                    displayImg.classList.remove("hidden");
                    defaultIcon.classList.add("hidden");
                }
    
                popupVisible = false;
                popup.classList.remove("show");
    
                console.log(`Reaction: ${currentReaction || 'none'}`);
            });
        });
    });
    
    
    
    // Top like icon popup handlers
    topIcons.forEach((icon) => {
        const container = icon.closest(".relative");
        const popup = container.querySelector(".reaction-popup");
    
        icon.addEventListener("mouseenter", () => {
            popup.classList.add("show");
        });
    
        icon.addEventListener("mouseleave", () => {
            popup.classList.remove("show");
        });
    
        popup.addEventListener("mouseenter", () => {
            popup.classList.add("show");
        });
    
        popup.addEventListener("mouseleave", () => {
            popup.classList.remove("show");
        });
    });
    
    
    document.querySelectorAll('.see-more-btn').forEach((seeMoreBtn) => {
        const container = seeMoreBtn.closest('p'); // The <p> wrapper
        const hideBtn = container.querySelector('.hide-btn');
        const preview = container.querySelector('.announcement-preview');
        const full = container.querySelector('.announcement-full');
    
        seeMoreBtn.addEventListener('click', () => {
            preview.style.display = 'none';
            full.style.display = 'inline';
            seeMoreBtn.style.display = 'none';
            hideBtn.style.display = 'inline';
        });
    
        hideBtn.addEventListener('click', () => {
            preview.style.display = 'inline';
            full.style.display = 'none';
            seeMoreBtn.style.display = 'inline';
            hideBtn.style.display = 'none';
        });
    });
    
});