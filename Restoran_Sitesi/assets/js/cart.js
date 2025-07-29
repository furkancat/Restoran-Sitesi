document.addEventListener('DOMContentLoaded', function() {
    // Sepete ekle butonları
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
            e.preventDefault();
            const button = e.target.classList.contains('add-to-cart') ? e.target : e.target.closest('.add-to-cart');
            const productId = button.getAttribute('data-id');
            
            addToCart(productId);
        }
        
        // Sepetten çıkar butonu
        if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            e.preventDefault();
            const button = e.target.classList.contains('remove-item') ? e.target : e.target.closest('.remove-item');
            const productId = button.getAttribute('data-id');
            
            removeFromCart(productId);
        }
        
        // Miktar azaltma butonu
        if (e.target.classList.contains('minus') || e.target.closest('.minus')) {
            e.preventDefault();
            const button = e.target.classList.contains('minus') ? e.target : e.target.closest('.minus');
            const productId = button.getAttribute('data-id');
            
            updateCartItemQuantity(productId, -1);
        }
        
        // Miktar artırma butonu
        if (e.target.classList.contains('plus') || e.target.closest('.plus')) {
            e.preventDefault();
            const button = e.target.classList.contains('plus') ? e.target : e.target.closest('.plus');
            const productId = button.getAttribute('data-id');
            
            updateCartItemQuantity(productId, 1);
        }
    });

    // Sepete ekle fonksiyonunu güncelleyin
    function addToCart(productId) {
    fetch('ajax/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}`
    })
    .then(response => {
        if (!response.ok) throw new Error('HTTP Hatası: ' + response.status);
        return response.json();
    })
    .then(data => {
        console.log("AJAX Yanıtı:", data); // Debug için
        if (data.success) {
            updateCartUI(data.cart_count, data.cart);
            showAlert('Ürün sepete eklendi!');
        } else {
            showAlert('Hata: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error("Fetch Hatası:", error);
        showAlert('Bir hata oluştu, lütfen tekrar deneyin.', 'error');
    });
}

    // Sepetten çıkar fonksiyonu
    function removeFromCart(productId) {
        fetch('ajax/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                updateCartUI(data.cart_count, data.cart);
                showAlert('Ürün sepetten çıkarıldı!');
            } else {
                showAlert('Hata: ' + data.message, 'error');
            }
        });
    }

    // Miktar güncelleme fonksiyonu
    function updateCartItemQuantity(productId, change) {
        fetch('ajax/update_cart_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&change=${change}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                updateCartUI(data.cart_count, data.cart);
            } else {
                showAlert('Hata: ' + data.message, 'error');
            }
        });
    }

    // Sepet UI güncelleme
   function updateCartUI(cartCount, cartItems) {
    console.log("Sepet Güncelleniyor:", { cartCount, cartItems });

    // Sepet sayacı güncelle
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = cartCount;
        el.style.display = 'flex';
    });

    // Sepet içeriğini AJAX ile güncelle
    fetch(`partials/cart_items.php?t=${new Date().getTime()}`)
        .then(response => response.text())
        .then(html => {
            const cartContainer = document.querySelector('.cart-items-container');
            if (cartContainer) {
                // Direkt içeriği güncelle (eskiyi tamamen değiştir)
                cartContainer.innerHTML = html;
            }
        });
}




    // Bildirim göster
    function showAlert(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
});