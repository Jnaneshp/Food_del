<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Restaurants - FoodieExpress</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <style>
    #restaurant-list {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
      justify-content: center;
    }

    .restaurant-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 8px #eee;
      width: 260px;
      margin-bottom: 24px;
      padding: 18px 16px 12px 16px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: box-shadow 0.2s;
    }

    .restaurant-card:hover {
      box-shadow: 0 4px 16px #ddd;
    }

    .restaurant-card img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .restaurant-card h4 {
      margin: 0 0 6px 0;
      font-size: 1.1em;
    }

    .restaurant-card p {
      margin: 0 0 10px 0;
      color: #888;
      font-size: 0.95em;
    }

    .restaurant-card button {
      background: #ff5722;
      color: #fff;
      border: none;
      padding: 8px 18px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 8px;
    }

    .menu-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin-top: 20px;
    }

    .menu-item {
      background: #fafafa;
      border-radius: 10px;
      box-shadow: 0 1px 4px #eee;
      width: 220px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 12px;
    }

    .menu-item img {
      width: 100%;
      height: 110px;
      object-fit: cover;
      border-radius: 7px;
      margin-bottom: 10px;
    }

    .menu-item-content h3 {
      font-size: 1em;
      margin: 0 0 8px 0;
    }

    .menu-item-content button {
      background: #ff5722;
      color: #fff;
      border: none;
      padding: 6px 14px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <header>
    <h1>🍽 FoodieExpress</h1>
    <nav>
      <a href="index.html">Home</a>
      <a href="restaurant.php">Restaurants</a>
      <a href="payment.html">Payment</a>
      <a href="contact.html">Contact</a>
      <a href="about.html">About</a>
      <a href="profile.php">Profile</a>
      <a href="cart.html">Cart (<span id="cart-count">0</span>)</a>
    </nav>
  </header>

  <div class="container">
    <h2>Our Restaurants</h2>
    <div id="restaurant-list"></div>
    <div id="menu-section" style="display:none;">
      <h2 id="menu-title"></h2>
      <div class="menu-grid" id="menu-grid"></div>
      <button onclick="backToRestaurants()">Back to Restaurants</button>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let count = cart.reduce((total, item) => total + item.quantity, 0);
      const cartCount = document.getElementById("cart-count");
      if (cartCount) cartCount.textContent = count;
      fetchRestaurants();
    });


    function fetchRestaurants() {
      fetch('admin_menu.php')
        .then(res => res.json())
        .then(data => {
          const list = document.getElementById('restaurant-list');
          list.innerHTML = '';
          data.forEach(restaurant => {
            const card = document.createElement('div');
            card.className = 'restaurant-card';
            card.innerHTML = `
              <img src="${restaurant.image_path ? restaurant.image_path : 'pic/food background.jpeg'}" alt="${restaurant.name}">
              <h4>${restaurant.name}</h4>
              <p>${restaurant.location}</p>
              <button onclick="loadMenu(${restaurant.id}, '${restaurant.name.replace(/'/g, "\\'")}')">View Menu</button>
            `;
            list.appendChild(card);
          });
        });
    }

    function loadMenu(restaurantId, restaurantName) {
      fetch(`get_menu.php?restaurant_id=${restaurantId}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('restaurant-list').style.display = 'none';
          document.getElementById('menu-section').style.display = 'block';
          document.getElementById('menu-title').textContent = `Menu for ${restaurantName}`;
          const grid = document.getElementById('menu-grid');
          grid.innerHTML = '';
          data.forEach(row => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'menu-item';
            const imgPath = row.image_path ? (row.image_path.startsWith('pic/') ? row.image_path : `pic/${row.image_path}`) : 'pic/food background.jpeg';
            itemDiv.innerHTML = `<img src="${imgPath}" alt="${row.name}" onerror="this.src='pic/food background.jpeg';this.onerror=null;"><div class="menu-item-content"><h3>${row.name} - $${row.price}</h3><button onclick=\"addToCart('${row.name}', ${row.price})\">Add to Cart</button></div>`;
            grid.appendChild(itemDiv);
          });
        });
    }

    function backToRestaurants() {
      document.getElementById('menu-section').style.display = 'none';
      document.getElementById('restaurant-list').style.display = 'block';
    }

    function addToCart(name, price) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      let found = cart.find(item => item.name === name);
      if (found) found.quantity += 1;
      else cart.push({
        name,
        price,
        quantity: 1
      });
      localStorage.setItem("cart", JSON.stringify(cart));
      document.getElementById("cart-count").textContent = cart.reduce((t, i) => t + i.quantity, 0);
      alert("Added to cart!");
    }
  </script>
</body>

</html>