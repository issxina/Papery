// ใช้ user id ที่ส่งมาจาก Blade
const userId = window.appUserId;
const CART_KEY = `papery_cart_${userId}`;

// ===== ฟังก์ชันพื้นฐาน =====
function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY)) || [];
}

function setCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

// ===== อัปเดต badge =====
function updateCartBadge() {
  const cart = getCart();
  const totalQty = cart.reduce((sum, i) => sum + (Number(i.qty) || 1), 0);

  const badge = document.getElementById("cartBadge");
  if (badge) badge.textContent = totalQty;

  const badgeMobile = document.getElementById("cartBadgeMobile");
  if (badgeMobile) badgeMobile.textContent = totalQty;
}


function updateHiddenInput() {
    const input = document.getElementById("cartJson");
    if (input) input.value = JSON.stringify(getCart());
}

// ===== เคลียร์เฉพาะรายการที่ชำระแล้ว =====
function clearPaidItems(paidIds) {
    if (!Array.isArray(paidIds) || paidIds.length === 0) return;
    const paidSet = new Set(paidIds.map(String)); // แปลงเป็น string ทั้งหมด
    let cart = getCart();
    cart = cart.filter((item) => !paidSet.has(String(item.id)));
    setCart(cart);
}

// ===== Render ตะกร้า =====
function renderCart() {
    const cart = getCart();
    const cartList = document.getElementById("cartList");
    const totalEl = document.getElementById("total");

    if (!cartList || !totalEl) return;

    cartList.innerHTML = "";

    cart.forEach((item) => {
        if (!item.id || !item.title || !item.price) return;

        cartList.innerHTML += `
          <li class="list-group-item d-flex align-items-start gap-3 cart-item shadow-sm rounded mb-2" data-id="${
              item.id
          }">
            <input class="form-check-input cart-check align-self-center book-checkbox" type="checkbox" value="${
                item.id
            }" checked />
            <img src="${
                item.img
            }" class="rounded border" width="64" height="86" alt="">
            <div class="flex-grow-1">
              <div class="fw-bold">${item.title}</div>
              <div class="small">฿${item.price.toFixed(2)}</div>
            </div>
            <div class="d-flex align-self-center gap-4">
                <div class="qty-controls">
                    <button class="btn btn-sm btn-qty decrease">-</button>
                    <span class="mx-2 fw-bold">${item.qty}</span>
                    <button class="btn btn-sm btn-qty increase">+</button>
                </div>
                <button class="btn btn-sm remove-item">ลบ</button>
            </div>
          </li>`;
    });

    updateSelectedTotal();
    updateHiddenInput();
}

// ===== คำนวณยอด =====
function updateSelectedTotal() {
    const cart = getCart();
    const totalEl = document.getElementById("total");
    const modalTotal = document.getElementById("modalTotal");

    let sum = 0;
    document.querySelectorAll(".book-checkbox:checked").forEach((cb) => {
        const item = cart.find((i) => i.id == cb.value);
        if (item) sum += item.price * (item.qty || 1);
    });

    if (totalEl) totalEl.textContent = "฿" + sum.toFixed(2);
    if (modalTotal) modalTotal.textContent = "฿" + sum.toFixed(2);
}

// ===== Event =====
document.addEventListener("click", (e) => {
    const cart = getCart();

    // เพิ่ม/ลดจำนวน
    if (
        e.target.classList.contains("increase") ||
        e.target.classList.contains("decrease")
    ) {
        const id = e.target.closest(".cart-item").dataset.id;
        const item = cart.find((i) => i.id == id);

        if (item) {
            if (e.target.classList.contains("increase")) item.qty++;
            if (e.target.classList.contains("decrease") && item.qty > 1)
                item.qty--;
        }
        setCart(cart);
        updateCartBadge();
        renderCart();
    }

    // ลบ
    if (e.target.classList.contains("remove-item")) {
        const id = e.target.closest(".cart-item").dataset.id;
        const newCart = cart.filter((i) => i.id != id);
        setCart(newCart);
        updateCartBadge();
        renderCart();
    }

    // เพิ่มจากปุ่ม "เพิ่มเข้าตะกร้า"
    if (e.target.classList.contains("add-to-cart")) {
        e.preventDefault();
        const book = {
            id: e.target.dataset.id,
            title: e.target.dataset.title,
            price: parseFloat(e.target.dataset.price),
            img: e.target.dataset.img,
            qty: 1,
        };
        let existing = cart.find((i) => i.id == book.id);
        if (existing) existing.qty++;
        else cart.push(book);

        setCart(cart);
        updateCartBadge();
        renderCart();
    }
});

document.addEventListener("change", (e) => {
    if (e.target.classList.contains("book-checkbox")) {
        updateSelectedTotal();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    updateCartBadge();
    renderCart();
});

// ===== ก่อน submit form =====
/* document.getElementById("cartForm")?.addEventListener("submit", function () {
    updateHiddenInput();
}); */

document.getElementById("cartForm").addEventListener("submit", function (e) {
    // เอา cart จาก localStorage ผ่านฟังก์ชัน getCart() ที่มาจาก cart.js
    const cart = getCart();

    // เก็บ id ของ item ที่ติ๊กไว้ (เป็น string)
    const selectedIds = Array.from(
        document.querySelectorAll(".book-checkbox:checked")
    ).map((cb) => String(cb.value));

    // filter cart -> เฉพาะ item ที่เลือก (แปลง item.id เป็น string เพื่อให้ match)
    const selectedCart = cart.filter((item) =>
        selectedIds.includes(String(item.id))
    );

    // set ค่า hidden input ให้เป็น JSON ของ selectedCart
    document.getElementById("cartJson").value = JSON.stringify(selectedCart);

    // ถ้าต้องการให้ต้องเลือกอย่างน้อย 1 รายการ
    if (selectedCart.length === 0) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "ไม่มีรายการ",
            text: "โปรดเลือกอย่างน้อย 1 หนังสือที่จะชำระ",
        });
        return false;
    }

    // ปล่อยให้ submit ปกติดำเนินการต่อ
});
