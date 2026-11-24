const CART_KEY = "forge_cart";

/* =========================
   GET CART
========================= */

function getCart() {
  return JSON.parse(localStorage.getItem(CART_KEY)) || [];
}


/* =========================
   SAVE CART
========================= */

function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}


/* =========================
   ADD PRODUCT TO CART
========================= */

function addToCart(productId, size = null, color = null, quantity = 1) {

  const product = PRODUCTS.find(p => p.id === productId);

  if (!product) {
    console.error("Product not found:", productId);
    return;
  }

  // If no size was selected, use the first available size
  if (!size) {
    size = product.sizes[0];
  }

  // If no color was selected, use the first available color
  if (!color) {
    color = product.colors[0];
  }

  const cart = getCart();

  // Check if the exact same product + size + color already exists
  const existingItem = cart.find(item =>
    item.id === productId &&
    item.size === size &&
    item.color === color
  );

  if (existingItem) {

    existingItem.quantity += quantity;

  } else {

    cart.push({
      id: product.id,
      name: product.name,
      price: product.price,
      img: product.img,
      size: size,
      color: color,
      quantity: quantity
    });

  }

  saveCart(cart);

  updateCartUI();

  // Open cart if cart drawer exists
  if (document.getElementById("cartDrawer")) {
    toggleCart(true);
  }
}


/* =========================
   REMOVE ITEM
========================= */

function removeFromCart(index) {

  const cart = getCart();

  cart.splice(index, 1);

  saveCart(cart);

  updateCartUI();
}


/* =========================
   CHANGE QUANTITY
========================= */

function changeCartQuantity(index, amount) {

  const cart = getCart();

  if (!cart[index]) return;

  cart[index].quantity += amount;

  // Remove item if quantity reaches 0
  if (cart[index].quantity <= 0) {
    cart.splice(index, 1);
  }

  saveCart(cart);

  updateCartUI();
}


/* =========================
   CART COUNT
========================= */

function getCartCount() {

  const cart = getCart();

  return cart.reduce(
    (total, item) => total + item.quantity,
    0
  );
}


/* =========================
   CART SUBTOTAL
========================= */

function getCartSubtotal() {

  const cart = getCart();

  return cart.reduce(
    (total, item) =>
      total + (item.price * item.quantity),
    0
  );
}


/* =========================
   UPDATE CART UI
========================= */

function updateCartUI() {

  const cart = getCart();

  const count = getCartCount();

  const subtotal = getCartSubtotal();


  /* Cart number */

  document.querySelectorAll(".cart-count").forEach(element => {
    element.textContent = count;
  });


  /* Cart title */

  const cartTitle = document.querySelector(".cart-head h3");

  if (cartTitle) {
    cartTitle.textContent = `Your Bag (${count})`;
  }


  /* Cart subtotal */

  const subtotalElement =
    document.querySelector(".cart-subtotal span:last-child");

  if (subtotalElement) {
    subtotalElement.textContent =
      `$${subtotal.toFixed(2)}`;
  }


  /* Cart items */

  const cartContainer =
    document.querySelector(".cart-items");

  if (!cartContainer) return;


  /* Empty cart */

  if (cart.length === 0) {

    cartContainer.innerHTML = `
      <p class="cart-empty">
        Your bag is empty.
      </p>
    `;

    return;
  }


  /* Render cart */

  cartContainer.innerHTML = cart.map((item, index) => {

    const itemTotal =
      item.price * item.quantity;

    return `

      <div class="cart-line">

        <img
          src="${item.img}"
          alt="${item.name}"
        >

        <div class="cart-line-info">

          <div class="cart-line-top">

            <h4>${item.name}</h4>

            <button
              class="remove-line"
              onclick="removeFromCart(${index})"
            >
              Remove
            </button>

          </div>

          <div class="meta">
            SIZE ${item.size} · ${item.color}
          </div>

          <div
            class="qty-stepper"
            data-price="${item.price}"
          >

            <button
              onclick="changeCartQuantity(${index}, -1)"
            >
              −
            </button>

            <span>
              ${item.quantity}
            </span>

            <button
              onclick="changeCartQuantity(${index}, 1)"
            >
              +
            </button>

          </div>

        </div>

        <div class="price-row">
          $${itemTotal.toFixed(2)}
        </div>

      </div>

    `;

  }).join("");
}


/* =========================
   OPEN / CLOSE CART
========================= */

function toggleCart(open) {

  const drawer =
    document.getElementById("cartDrawer");

  const overlay =
    document.getElementById("overlay");

  if (!drawer || !overlay) return;


  if (open) {

    drawer.classList.add("active");
    overlay.classList.add("active");

    updateCartUI();

  } else {

    drawer.classList.remove("active");
    overlay.classList.remove("active");

  }
}


/* =========================
   INITIALIZE
========================= */

document.addEventListener(
  "DOMContentLoaded",
  function () {

    updateCartUI();

  }
);