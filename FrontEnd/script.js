// Hero Carousel
const heroCarousel = {
    images: [
        'images/header1.jpg',
        'images/header2.jpg',
        'images/header3.jpg',
        'images/header4.jpg',
        'images/header5.jpg'
    ],
    currentIndex: 0,
    heroSection: null,
    indicators: null,

    init() {
        this.heroSection = document.querySelector('.hero-section');
        this.indicators = document.querySelectorAll('.carousel-indicator');
        if (this.heroSection) {
            this.showImage(0);
            this.updateIndicators(0);
            this.startCarousel();
        }
    },

    showImage(index) {
        if (this.heroSection) {
            this.heroSection.style.backgroundImage = `url('${this.images[index]}')`;
        }
    },

    updateIndicators(index) {
        this.indicators.forEach((indicator, i) => {
            indicator.classList.remove('active');
            if (i === index) {
                indicator.classList.add('active');
            }
        });
    },

    nextImage() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.showImage(this.currentIndex);
        this.updateIndicators(this.currentIndex);
    },

    goToImage(index) {
        this.currentIndex = index;
        this.showImage(this.currentIndex);
        this.updateIndicators(this.currentIndex);
    },

    startCarousel() {
        setInterval(() => {
            this.nextImage();
        }, 2000); // 2 seconds slide
    }
};

// Simple cart implementation using localStorage
function getCart() {
    try {
        return JSON.parse(localStorage.getItem('aw_cart') || '[]');
    } catch (e) {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem('aw_cart', JSON.stringify(cart));
}

function updateCartCount() {
    const cart = getCart();
    const count = cart.reduce((sum, it) => sum + (it.quantity || 1), 0);
    const badge = document.getElementById('cart-count');
    if (badge) badge.textContent = count;
}

function addToCart(item) {
    const cart = getCart();
    const existing = cart.find(i => String(i.id) === String(item.id));
    if (existing) {
        existing.quantity = (existing.quantity || 1) + 1;
    } else {
        item.quantity = 1;
        cart.push(item);
    }
    saveCart(cart);
    updateCartCount();
}

function renderCartContents() {
    const container = document.getElementById('cart-contents');
    if (!container) return;
    const cart = getCart();
    if (!cart.length) {
        container.innerHTML = '<p style="margin:8px 0;">Your cart is empty.</p>';
        return;
    }

    let totalItems = cart.reduce((s, it) => s + it.quantity, 0);
    let html = `<p style="margin:6px 0; font-weight:600;">${totalItems} item${totalItems>1?'s':''} in cart</p>`;
    html += '<div style="display:flex; flex-direction:column; gap:8px;">';
    cart.forEach(it => {
        html += `
          <div style="display:flex; gap:8px; align-items:center; border-bottom:1px solid #efefef; padding-bottom:8px;">
            <img src="images/${it.image}" alt="${it.name}" style="width:56px; height:56px; object-fit:cover; border-radius:4px;">
            <div style="flex:1;">
              <div style="font-size:13px; font-weight:600;">${it.name}</div>
              <div style="font-size:13px; color:#666;">₹${it.price} × ${it.quantity}</div>
            </div>
            <div style="font-weight:600;">₹${(it.price * it.quantity).toFixed(2)}</div>
          </div>
        `;
    });
    html += '</div>';
    container.innerHTML = html;
}

function clearCart() {
    localStorage.removeItem('aw_cart');
    updateCartCount();
    renderCartContents();
}

function checkout() {
    alert('Checkout is not implemented in this demo.');
}

// Start carousel and cart when page loads
document.addEventListener('DOMContentLoaded', () => {
    heroCarousel.init();
    updateCartCount();
    renderCartContents();

    // Event delegation for add-to-cart buttons
    document.body.addEventListener('click', (e) => {
        const btn = e.target.closest && e.target.closest('.add-btn');
        if (!btn) return;
        // find product box container
        const box = btn.closest && btn.closest('.box');
        if (!box) return;
        const item = {
            id: box.dataset.id || null,
            name: box.dataset.name || (box.querySelector('.product-title') && box.querySelector('.product-title').textContent.trim()),
            price: parseFloat(box.dataset.price || (box.querySelector('.price') && box.querySelector('.price').textContent.replace(/[₹,\s]/g, '')) || 0),
            image: box.dataset.image || ''
        };
        addToCart(item);
        // show quick feedback: briefly open cart and then keep it open for user
        const cartBox = document.getElementById('cart-box');
        if (cartBox) {
            cartBox.style.display = 'block';
            renderCartContents();
        }
    });

    // When cart box is clicked (open), ensure contents are up-to-date
    const cartBoxButton = document.querySelector('.nav-cart');
    if (cartBoxButton) {
        cartBoxButton.addEventListener('click', () => {
            renderCartContents();
            updateCartCount();
        });
    }
});

