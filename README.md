# Shoes E-commerce Store 
This project is a comprehensive e-commerce platform for purchasing shoes, featuring real-time notifications, social authentication, dynamic cart management, and a robust admin panel. The application is fully containerized with Docker to ensure reliable and scalable deployment.

---

### **Database Schema**  
![drawSQL-image-export-2025-02-06](https://github.com/user-attachments/assets/52bbe47b-b3a7-4a85-9e51-066724f8d37d)

---

### **Key Features**  

- **Real-Time Notifications**: Integrated Laravel Echo and Pusher to provide real-time updates for order statuses, promotions, and more.
- **Payment Gateway Integration**: Supports Stripe Payment Gateway. 
- **Multi-Authentication System**: Supports multiple auth guards for users and admins, ensuring secure role-based access.  
- **Social Authentication**: Implemented using Laravel Socialite, allowing users to log in or register via Google and GitHub OAuth providers.  
- **Dynamic Shopping Cart**: A custom-built shopping cart system that adapts to user preferences and supports seamless item addition, removal, and updates.  
- **PDF Invoice Generation**: Automatically generates downloadable invoices for each order.
- **Dockerized Setup**: Fully containerized with Docker to standardize development and simplify deployment.
- **Redis Caching**: Optimized performance by caching frequently accessed data using Redis.  
- **Search and Filter**: Advanced search functionality with filters for brand, size, price range, and ratings.  
- **Rating and Review System**: Users can rate and review purchased products, enhancing customer engagement.  
- **Admin Panel**: A dedicated admin dashboard for managing products, users, orders, and reviews.  
- **Reset Password Mail**: Allows users to reset their passwords securely via email.  


---

### **Technologies Used**  

- **Laravel 11**: Core framework for building the application.  
- **Pusher and Echo**: For implementing real-time notifications.  
- **Laravel Socialite**: Handles OAuth-based social logins.  
- **Redis**: Speeds up the application with efficient caching.  
- **Docker**: Ensures consistent and scalable deployments.  
- **MySQL**: Backend database for storing application data.  

---

### **Arabic Supported**
![Screenshot 2025-02-06 072104](https://github.com/user-attachments/assets/93fe81c6-49e6-432f-9a70-795127c442ca)

### **Docker and Deployment**  
<p align="center"><a href="https://www.docker.com/" target="_blank"><img src="https://github.com/user-attachments/assets/1511730a-e1cb-4a3f-b605-8f35cad40027" width="400" alt="Docker Logo"></a></p>

The project is fully containerized using Docker and Docker Compose for simplified setup and deployment.  
- Apache and MySQL services run in Docker containers.  
- Laravel serves the application from the `/public` directory.  

---

### **Getting Started**  

#### **Clone the Repository**  
```bash
git clone https://github.com/mohamedmagdy841/shoes-ecommerce-store.git
cd shoes-ecommerce-store
```

#### **Set up Docker**  
Ensure Docker is installed, then start the containers:  
```bash
docker-compose up
```

#### **Configure Environment**  
Set up the `.env` file with database credentials, Pusher keys, Redis configuration, and OAuth credentials for Google and GitHub.  

#### **Run Migrations and Seeders**  
```bash
php artisan migrate --seed
```

#### **Access the Application**  
Visit `http://localhost` in your browser to explore the platform.


### **Project Demo**
