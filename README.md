# FoodieExpress

FoodieExpress is a web-based food ordering and restaurant management platform designed to streamline the process of browsing menus, placing orders, and managing restaurant operations. The project features both user and admin interfaces, secure authentication, and a modern, responsive design.

## Features

- User registration and login
- Admin registration, login, and dashboard
- Restaurant and menu management
- Order placement and tracking
- Shopping cart functionality
- Payment integration (frontend)
- Contact and About pages
- Responsive, mobile-friendly UI

## Technologies Used

- HTML5, CSS3 (with custom styles and Google Fonts)
- PHP (for backend logic and server-side scripts)
- MySQL (database, see `foodieexpress_schema.sql`)
- JavaScript (if included in your project)
- XAMPP (recommended local development environment)

## Project Structure

```
foodieexpress/
├── .vscode/                # VSCode settings (optional)
├── about.html              # About page
├── admin_dashboard.html    # Admin dashboard UI
├── admin_login.html        # Admin login page
├── admin_login.php         # Admin login backend
├── admin_menu.php          # Admin menu management backend
├── admin_orders.html       # Admin orders UI
├── admin_orders.php        # Admin orders backend
├── admin_register.html     # Admin registration page
├── admin_register.php      # Admin registration backend
├── admin_restaurant.php    # Admin restaurant management backend
├── cart.html               # Shopping cart page
├── config.php              # Database configuration
├── contact.html            # Contact page
├── foodieexpress_schema.sql# Database schema
├── get_menu.php            # Fetch menu items
├── get_user_address.php    # Fetch user address
├── index.html              # Home page
├── login.html              # User login page
├── login.php               # User login backend
├── logout.php              # Logout script
├── payment.html            # Payment page (frontend)
├── pic/                    # Images and assets
├── profile.php             # User profile backend
├── register.html           # User registration page
├── register.php            # User registration backend
├── restaurant.php          # Restaurant listing page
├── style.css               # Main stylesheet
├── submit_order.php        # Order submission backend
```

## Installation & Setup

1. **Clone or Download** this repository to your local machine.
2. **Install XAMPP** (or any LAMP/WAMP stack) and start Apache & MySQL.
3. **Copy Project Folder** to your XAMPP `htdocs` directory (e.g., `C:/xampp/htdocs/foodieexpress`).
4. **Import Database**:
   - Open phpMyAdmin.
   - Create a new database (e.g., `foodieexpress`).
   - Import `foodieexpress_schema.sql` to set up tables.
5. **Configure Database Connection**:
   - Edit `config.php` with your MySQL credentials if needed.
6. **Access the Website**:
   - Open your browser and go to `http://localhost/foodieexpress/`.

## Usage

- **Users** can register, log in, browse restaurants and menus, add items to the cart, and place orders.
- **Admins** can register, log in, manage restaurants, menus, and view orders via the dashboard.
- Use the navigation bar to access different sections (Home, Restaurants, Payment, Contact, About).

## File/Folder Descriptions

- **HTML Files**: Frontend pages for users and admins.
- **PHP Files**: Backend logic for authentication, menu management, order processing, etc.
- **style.css**: Custom styles for consistent UI/UX.
- **pic/**: Contains all image assets used in the website.
- **foodieexpress_schema.sql**: SQL file to set up the database structure.

## Contribution

Contributions are welcome! Please fork the repository and submit a pull request. For major changes, open an issue first to discuss what you would like to change.

## Contact

For questions, suggestions, or support, please contact the project maintainer at [jnaneshppalan@gmail.com] or use the Contact page on the website.

---

FoodieExpress © 2024. All rights reserved.
