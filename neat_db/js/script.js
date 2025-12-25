// script.js
const CART_KEY = "neat_cart_v1";

/* ---------- helper ---------- */
function rupiah(n) { return "Rp" + Number(n).toLocaleString("id-ID"); }
function getCart() { return JSON.parse(localStorage.getItem(CART_KEY) || "{}"); }
function saveCart(cart, callback) { localStorage.setItem(CART_KEY, JSON.stringify(cart)); updateCartIndicator(); if(callback) callback(); }

/* ---------- Cart indicator ---------- */
function updateCartIndicator() {
  const el = document.getElementById("cartCount");
  if(!el) return;
  const cart = getCart();
  const count = Object.values(cart).reduce((s,i)=>s+(i.qty||0),0);
  el.textContent = count;
}

/* ---------- Hamburger ---------- */
document.getElementById("hamburgerBtn")?.addEventListener("click", ()=>document.getElementById("hamburgerOverlay")?.classList.add("active"));
document.getElementById("closeHamburger")?.addEventListener("click", ()=>document.getElementById("hamburgerOverlay")?.classList.remove("active"));

/* ---------- Toast ---------- */
let toastTimer = null;
function showToast(msg="Produk ditambahkan ke keranjang") {
  const t = document.getElementById("toast");
  if(!t) return;
  t.textContent = msg;
  t.classList.remove("hidden");
  clearTimeout(toastTimer);
  toastTimer = setTimeout(()=>t.classList.add("hidden"),1800);
}

/* ---------- Cart modal ---------- */
function openCart() { document.getElementById("cartModal")?.classList.remove("hidden"); renderCartItems(); }
function closeCart() { document.getElementById("cartModal")?.classList.add("hidden"); }

/* ---------- Cart ops ---------- */
function addToCart(item) {
  const cart = getCart();
  const id = item.id.toString();
  if(!cart[id]) cart[id] = { id, name: item.name, price: item.price, qty: 0 };
  cart[id].qty += Math.max(1,item.qty||1);
  saveCart(cart, ()=>{ renderCartItems(); showToast(); });
}

function changeQty(id, delta) {
  const cart = getCart();
  if(!cart[id]) return;
  cart[id].qty += delta;
  if(cart[id].qty<=0) delete cart[id];
  saveCart(cart, renderCartItems);
}

function removeItem(id) {
  const cart = getCart();
  if(!cart[id]) return;
  delete cart[id];
  saveCart(cart, renderCartItems);
}

function clearCart() {
  localStorage.removeItem(CART_KEY);
  updateCartIndicator();
  renderCartItems();
}

/* ---------- Render cart items ---------- */
function renderCartItems() {
  const container = document.getElementById("cartItems");
  const totalEl = document.getElementById("cartTotal");
  if(!container||!totalEl) return;
  const cart = getCart();
  container.innerHTML = "";
  const ids = Object.keys(cart);
  if(ids.length===0){ container.innerHTML="<p>Keranjang kosong.</p>"; totalEl.textContent=rupiah(0); return; }

  let total = 0;
  ids.forEach(id=>{
    const it = cart[id];
    const subtotal = it.qty*it.price;
    total+=subtotal;
    const row = document.createElement("div");
    row.className="cart-item";
    row.dataset.id=id;
    row.innerHTML=`
      <div class="ci-left">
        <div class="ci-name">${escapeHtml(it.name)}</div>
        <div class="ci-price">${rupiah(it.price)} x ${it.qty}</div>
      </div>
      <div class="qty-controls">
        <button class="dec" data-id="${id}">-</button>
        <div>${it.qty}</div>
        <button class="inc" data-id="${id}">+</button>
        <button class="remove" data-id="${id}" title="Hapus">🗑</button>
      </div>
    `;
    container.appendChild(row);
  });
  totalEl.textContent=rupiah(total);
}

/* ---------- Event delegation for cart buttons ---------- */
document.addEventListener("click", e=>{
  const id = e.target.dataset?.id;
  if(e.target.classList.contains("inc")) changeQty(id,+1);
  if(e.target.classList.contains("dec")) changeQty(id,-1);
  if(e.target.classList.contains("remove")) removeItem(id);
});

/* ---------- Checkout ---------- */
async function checkout() {
  const cart = getCart();
  if(Object.keys(cart).length===0){ alert("Keranjang kosong!"); return; }
  const methodEl = document.querySelector('input[name="payment"]:checked');
  if(!methodEl){ alert("Pilih metode pembayaran!"); return; }

  const btn = document.getElementById("checkoutBtn");
  btn.disabled=true;
  try {
    const res = await fetch("checkout.php",{
      method:"POST",
      headers:{ "Content-Type":"application/json" },
      body:JSON.stringify({ cart:Object.values(cart), payment_method:methodEl.value })
    });
    const data = await res.json();
    if(data.status==="success"){
      clearCart(); closeCart(); openSuccessModal();
      console.log("ORDER ID:",data.order_id);
    } else alert(data.msg||"Checkout gagal");
  } catch(err){ console.error(err); alert("Checkout error"); }
  finally{ btn.disabled=false; }
}

/* ---------- Success modal ---------- */
function openSuccessModal(){ document.getElementById("successModal")?.classList.remove("hidden"); }
function closeSuccessModal(){ document.getElementById("successModal")?.classList.add("hidden"); }

/* ---------- Escape HTML ---------- */
function escapeHtml(s){ return String(s).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;"); }

/* ---------- Menu from DB ---------- */
let groupedMenu={};
function groupByCategory(data){
  return data.reduce((acc,item)=>{
    const cat=item.category||"main";
    if(!acc[cat]) acc[cat]=[];
    acc[cat].push({
      id:item.product_id,
      name:item.name,
      price:item.price,
      image:item.image_url,
      desc:item.description
    });
    return acc;
  },{});
}

/* ---------- Render menu ---------- */
function renderMenu(category){
  const container=document.getElementById("menuGrid");
  if(!container) return;
  container.innerHTML="";
  (groupedMenu[category]||[]).forEach(item=>{
    const card=document.createElement("article");
    card.className="menu-card";
    card.dataset.id=item.id;
    card.dataset.name=item.name;
    card.dataset.price=item.price;

    card.innerHTML=`
      <img src="${item.image}" alt="${escapeHtml(item.name)}">
      <div class="menu-card-content">
        <h3>${escapeHtml(item.name)}</h3>
        <p>${escapeHtml(item.desc)}</p>
        <div class="price">${rupiah(item.price)}</div>
        <div class="actions">
          <input class="qty-input" type="number" min="1" value="1">
          <button class="add-btn">Tambah</button>
        </div>
      </div>
    `;
    container.appendChild(card);
  });

  container.querySelectorAll(".add-btn").forEach(btn=>{
    btn.addEventListener("click",()=>{
      const card=btn.closest(".menu-card");
      const qty=Math.max(1,parseInt(card.querySelector(".qty-input").value,10)||1);
      addToCart({ id:card.dataset.id, name:card.dataset.name, price:parseInt(card.dataset.price,10), qty });
    });
  });
}

/* ---------- Init ---------- */
document.addEventListener("DOMContentLoaded", ()=>{
  // menuData dikirim dari PHP
  groupedMenu = groupByCategory(menuData);

  renderMenu("main"); // default category

  // category selection
  document.querySelectorAll(".category-card").forEach(card=>{
    card.addEventListener("click",()=>{
      document.querySelectorAll(".category-card").forEach(c=>c.classList.remove("active"));
      card.classList.add("active");
      renderMenu(card.dataset.category);
    });
  });

  // cart & checkout buttons
  document.getElementById("cartBtn")?.addEventListener("click", openCart);
  document.getElementById("closeCart")?.addEventListener("click", closeCart);
  document.getElementById("clearCart")?.addEventListener("click",()=>confirm("Kosongkan keranjang?")&&clearCart());
  document.getElementById("checkoutBtn")?.addEventListener("click", checkout);
  document.getElementById("closeSuccess")?.addEventListener("click", closeSuccessModal);

  updateCartIndicator();
});
