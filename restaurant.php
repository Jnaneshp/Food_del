<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurants - FoodieExpress</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <style>
    :root {
      --primary-color: #ff6b35;
      --secondary-color: #004e64;
      --accent-color: #f9dc5c;
      --text-dark: #2c3e50;
      --text-light: #7f8c8d;
      --white: #ffffff;
      --light-bg: #f8f9fa;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
      --gradient: linear-gradient(135deg, var(--primary-color), #ff8f65);
      --border-radius: 12px;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: var(--text-dark);
      background-color: var(--white);
    }

    /* Header Styles */
    header {
      background: linear-gradient(135deg, var(--secondary-color), #006080);
      color: var(--white);
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: var(--shadow);
    }

    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    header h1 {
      font-size: 2rem;
      font-weight: 700;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    nav {
      display: flex;
      gap: 2rem;
      align-items: center;
      flex-wrap: wrap;
    }

    nav a {
      color: var(--white);
      text-decoration: none;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: var(--border-radius);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    nav a::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: var(--gradient);
      transition: left 0.3s ease;
      z-index: -1;
    }

    nav a:hover::before {
      left: 0;
    }

    nav a:hover {
      transform: translateY(-2px);
    }

    /* Main Content */
    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 2rem;
    }

    .container h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 2rem;
      text-align: center;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Restaurant List */
    #restaurant-list {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
      margin-top: 2rem;
    }

    .restaurant-card {
      background: var(--white);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      width: 300px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .restaurant-card:hover {
      transform: translateY(-10px);
      box-shadow: var(--shadow-hover);
    }

    .restaurant-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .restaurant-card-content {
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .restaurant-card h4 {
      margin: 0 0 0.5rem 0;
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--text-dark);
    }

    .restaurant-card p {
      margin: 0 0 1.2rem 0;
      color: var(--text-light);
      font-size: 0.95rem;
    }

    .restaurant-card button {
      background: var(--gradient);
      color: var(--white);
      border: none;
      padding: 0.8rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
    }

    .restaurant-card button:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
    }

    /* Menu Section */
    #menu-section {
      margin-top: 2rem;
      text-align: center;
    }

    #menu-title {
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    .menu-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      justify-content: center;
      margin: 2rem 0;
    }

    .menu-item {
      background: var(--white);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      width: 250px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .menu-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }

    .menu-item img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }

    .menu-item-content {
      padding: 1.2rem;
      text-align: center;
    }

    .menu-item-content h3 {
      font-size: 1.1rem;
      margin: 0 0 1rem 0;
      color: var(--text-dark);
    }

    .menu-item-content button {
      background: var(--gradient);
      color: var(--white);
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 50px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
    }

    .menu-item-content button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
    }

    #menu-section>button {
      background: var(--secondary-color);
      color: var(--white);
      border: none;
      padding: 0.8rem 1.8rem;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 1rem;
      transition: all 0.3s ease;
    }

    #menu-section>button:hover {
      background: #006080;
      transform: translateY(-2px);
    }

    /* Animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }
  </style>
</head>

<body>
  <header>
    <div class="header-content">
      <h1>🍽 FoodieExpress</h1>
      <nav>
        <a href="index.html">Home</a>
        <a href="payment.html">Payment</a>
        <a href="contact.html">Contact</a>
        <a href="about.html">About</a>
        <a href="profile.php">Profile</a>
        <a href="cart.html">Cart (<span id="cart-count">0</span>)</a>
      </nav>
    </div>
  </header>

  <div class="container">
    <h2 class="fade-in">Our Restaurants</h2>
    <div id="restaurant-list" class="fade-in"></div>
    <div id="menu-section" style="display:none;" class="fade-in">
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
          data.forEach((restaurant, index) => {
            const card = document.createElement('div');
            card.className = 'restaurant-card';
            card.style.animationDelay = `${index * 0.1}s`;
            card.innerHTML = `
              <img src="${restaurant.image_path ? restaurant.image_path : 'pic/food background.jpeg'}" alt="${restaurant.name}" onerror="this.src='pic/food background.jpeg';">
              <div class="restaurant-card-content">
                <h4>${restaurant.name}</h4>
                <p>${restaurant.location}</p>
                <button onclick="loadMenu(${restaurant.id}, '${restaurant.name.replace(/'/g, "\\'")}')">View Menu</button>
              </div>
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
          document.getElementById('menu-title').style.background = 'var(--gradient)';
          document.getElementById('menu-title').style.webkitBackgroundClip = 'text';
          document.getElementById('menu-title').style.webkitTextFillColor = 'transparent';
          document.getElementById('menu-title').style.backgroundClip = 'text';

          const grid = document.getElementById('menu-grid');
          grid.innerHTML = '';
          data.forEach((row, index) => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'menu-item';
            itemDiv.style.animationDelay = `${index * 0.1}s`;
            itemDiv.classList.add('fade-in');
            const imgPath = row.image_path ? (row.image_path.startsWith('pic/') ? row.image_path : `pic/${row.image_path}`) : 'pic/food background.jpeg';
            itemDiv.innerHTML = `
              <img src="${imgPath}" alt="${row.name}" onerror="this.src='pic/food background.jpeg';this.onerror=null;">
              <div class="menu-item-content">
                <h3>${row.name} - $${row.price}</h3>
                <button onclick=\"addToCart('${row.name}', ${row.price})\">Add to Cart</button>
              </div>
            `;
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

      // Create a more modern notification instead of alert
      const notification = document.createElement('div');
      notification.style.position = 'fixed';
      notification.style.bottom = '20px';
      notification.style.right = '20px';
      notification.style.background = 'var(--gradient)';
      notification.style.color = 'white';
      notification.style.padding = '15px 25px';
      notification.style.borderRadius = 'var(--border-radius)';
      notification.style.boxShadow = 'var(--shadow)';
      notification.style.zIndex = '9999';
      notification.style.opacity = '0';
      notification.style.transform = 'translateY(20px)';
      notification.style.transition = 'all 0.3s ease';
      notification.textContent = `${name} added to cart!`;

      document.body.appendChild(notification);

      // Show notification with animation
      setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
      }, 10);

      // Remove notification after 3 seconds
      setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        setTimeout(() => document.body.removeChild(notification), 300);
      }, 3000);
    }
  </script>
</body>

</html>