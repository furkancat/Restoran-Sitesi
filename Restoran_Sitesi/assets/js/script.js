const searchForm = document.querySelector(".search-form");
const cartItem = document.querySelector(".cart-items-container");
const navbar = document.querySelector(".navbar");

//! buttons
const searchBtn = document.querySelector("#search-btn");
const cartBtn = document.querySelector("#cart-btn");
const menuBtn = document.querySelector("#menu-btn");

searchBtn.addEventListener("click", function () {
  searchForm.classList.toggle("active");
  document.addEventListener("click", function (e) {
    if (
      !e.composedPath().includes(searchBtn) &&
      !e.composedPath().includes(searchForm)
    ) {
      searchForm.classList.remove("active");
    }
  });
});

cartBtn.addEventListener("click", function () {
  cartItem.classList.toggle("active");
  document.addEventListener("click", function (e) {
    if (
      !e.composedPath().includes(cartBtn) &&
      !e.composedPath().includes(cartItem)
    ) {
      cartItem.classList.remove("active");
    }
  });
});

menuBtn.addEventListener("click", function () {
  navbar.classList.toggle("active");
  document.addEventListener("click", function (e) {
    if (
      !e.composedPath().includes(menuBtn) &&
      !e.composedPath().includes(navbar)
    ) {
      navbar.classList.remove("active");
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const q = urlParams.get('q');
  if (!q) return;

  // Sayfadaki tüm ürün öğelerini al
  const items = document.querySelectorAll('.product-item');
  const searchTerm = q.toLowerCase();

  for (let item of items) {
    // Ürün adı ve açıklamasını al
    const text = (item.textContent || "").toLowerCase();
    if (text.includes(searchTerm)) {
      // İlk eşleşmede vurgula
      item.style.backgroundColor = '#ffff99';  // açık sarı vurgusu örneği
      item.scrollIntoView({ behavior: 'smooth', block: 'center' });
      break; // ilk bulunanı işaretledikten sonra dur
    }
  }
});

