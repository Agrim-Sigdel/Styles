# Styles - E-Commerce Application

A full-featured e-commerce platform built with PHP and SQLite that allows users to browse, search, and purchase clothing items across multiple categories.

## Features

### User Management

- User registration and authentication
- Secure login/logout functionality
- Session-based user tracking
- Password security

### Product Catalog

- Browse products across three categories:
  - **Men's**: T-shirts, jeans, jackets, shoes, watches, hats, sunglasses, and more
  - **Women's**: Dresses, skirts, blouses, heels, bags, jewelry, and more
  - **Kids**: T-shirts, jeans, toys, and other children's clothing
- Product filtering by category
- Product images with pricing

### Shopping Features

- Shopping cart functionality (persistent cart management)
- Add/remove products from cart
- View cart with item quantities and prices
- Real-time cart total calculations

### Checkout & Orders

- Multi-step checkout process
- Customer information collection (email, phone, address)
- Order placement and confirmation
- Order confirmation page with order details
- Order history tracking in database

## Technology Stack

### Backend

- **Language**: PHP
- **Database**: SQLite (`style_website.db`)
- **Database Handler**: PDO (PHP Data Objects)

### Frontend

- **HTML5**: Semantic markup
- **CSS3**: Responsive design with custom stylesheets
- **JavaScript**: Client-side interactivity (cart management, UI interactions)
- **Font Awesome**: Icon library for UI elements
- **Google Fonts**: Poppins, Fredoka, Nunito, Open Sans, Quicksand

## Project Structure

```
app/Styles/
├── index.php                 # Home page (women's products)
├── men.php                   # Men's products page
├── women.php                 # Women's products page
├── kid.php                   # Kids' products page
├── login.php                 # User login page
├── register.php              # User registration page
├── logout.php                # User logout handler
├── session_check.php         # Session validation
├── checkout.php              # Checkout page
├── checkout.js               # Checkout form handling
├── place_order.php           # Order processing
├── confirmation.php          # Order confirmation page
├── cart.js                   # Shopping cart logic
├── get_cart_products.php     # Cart data retrieval
├── db_connection.php         # Database connection setup
├── console_logger.php        # Debugging helper
├── footer.php                # Footer component
├── setup.sql                 # Database schema and initial data
├── style.css                 # Main stylesheet
├── login.css                 # Login page stylesheet
├── men.css                   # Men's page stylesheet
├── assets/                   # Static assets
├── js/                       # JavaScript files
└── style_website.db          # SQLite database file
```

## Database Schema

### Users Table

Stores user credentials for authentication

- `id`: Primary key
- `email`: Unique user email
- `password`: Hashed password

### Products Table

Contains all available products

- `id`: Primary key
- `name`: Product name
- `category`: Product category (men, women, kid)
- `price`: Product price
- `image`: Product image URL

### Orders Table

Tracks customer purchases

- `id`: Primary key
- `user_id`: Reference to user
- `user_email`: Customer email
- `phone_number`: Customer phone
- `customer_address`: Delivery address
- `products`: Serialized product data
- `total_amount`: Order total
- `order_date`: Timestamp of order
- `FOREIGN KEY`: Links to users table

## Setup Instructions

### Prerequisites

- PHP 7.0 or higher
- Web server (Apache, Nginx, etc.)
- SQLite3 support in PHP

### Installation

1. **Clone/Download the project**

   ```bash
   cd /path/to/styles
   ```

2. **Initialize the database**

   ```bash
   sqlite3 app/Styles/style_website.db < app/Styles/setup.sql
   ```

3. **Configure database connection**
   - Update `db_connection.php` if needed with your database path

4. **Start your local server**

   ```bash
   php -S localhost:8000
   ```

5. **Access the application**
   - Open `http://localhost:8000/app/Styles/` in your browser

## Usage

### For Customers

1. **Register**: Create a new account with your email and password
2. **Login**: Sign in with your credentials
3. **Browse**: Explore products in Men's, Women's, or Kids' categories
4. **Add to Cart**: Click on products to add them to your shopping cart
5. **Checkout**: Review cart and proceed to checkout
6. **Confirm**: Enter shipping details and place your order
7. **Confirmation**: Receive order confirmation with details

### For Developers

- View console logs: Check `console_logger.php` for debugging
- Database queries: Modify PHP files to adjust product filtering or ordering
- Styling: Update CSS files in the root directory for design changes
- Cart logic: Modify `cart.js` for cart behavior customization

## Key Features Implementation

### Authentication

- Session-based authentication prevents unauthorized access
- Users must log in to access the store
- Automatic redirect to login for unauthenticated users

### Shopping Cart

- Client-side cart management with `cart.js`
- Cart data retrieved dynamically via `get_cart_products.php`
- Persistent cart calculations across pages

### Order Processing

- Form validation in `checkout.js`
- Server-side processing in `place_order.php`
- Order confirmation with complete details

## Future Enhancements

- Product search and filtering
- Customer reviews and ratings
- Wishlist functionality
- Payment gateway integration
- Order tracking
- Admin panel for inventory management
- Email notifications
- Multiple language support
- Mobile app version

## Security Considerations

- Implement prepared statements (already in use with PDO)
- Add input validation and sanitization
- Use password hashing (bcrypt recommended)
- Implement CSRF tokens
- Add rate limiting for login attempts
- Validate file uploads

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Test all changes thoroughly
2. Follow existing code style and conventions
3. Add comments for complex logic
4. Update this README if adding new features

## License

This project is open source and available under the MIT License.

## Support

For issues, questions, or suggestions, please open an issue in the project repository.
