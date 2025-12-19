<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ===============================
           SIDEBAR TOGGLE (UNCHANGED)
        =============================== */
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebarCollapseBtn = document.querySelector('.sidebar-collapse-btn');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar.classList.toggle('active');
            });
        }

        if (sidebarCollapseBtn) {
            sidebarCollapseBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar.classList.toggle('active');
            });
        }

        document.addEventListener('click', function (event) {
            if (
                window.innerWidth <= 992 &&
                sidebar.classList.contains('active') &&
                !sidebar.contains(event.target) &&
                !event.target.closest('.sidebar-toggle') &&
                !event.target.closest('.sidebar-collapse-btn')
            ) {
                sidebar.classList.remove('active');
            }
        });

        sidebar.addEventListener('click', e => e.stopPropagation());

        /* ===============================
           DARK MODE
        =============================== */
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            const isDark = localStorage.getItem('darkMode') === 'true';
            darkModeToggle.checked = isDark;
            document.body.classList.toggle('dark-mode', isDark);

            darkModeToggle.addEventListener('change', function () {
                document.body.classList.toggle('dark-mode', this.checked);
                localStorage.setItem('darkMode', this.checked);
            });
        }

        /* ===============================
           NOTIFICATIONS
        =============================== */
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                this.style.opacity = '0.6';
            });
        });

        /* ===============================
           BOOTSTRAP TOOLTIPS
        =============================== */
        document
            .querySelectorAll('[data-bs-toggle="tooltip"]')
            .forEach(el => new bootstrap.Tooltip(el));

        /* ===============================
           WINDOW RESIZE
        =============================== */
        window.addEventListener('resize', function () {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
            }
        });

    });
</script>

<script>
    // Dashboard-specific JavaScript

    document.addEventListener('DOMContentLoaded', function() {
        // Load sample data for tables
        loadProducts();
        loadOrders();
        loadCustomers();
        loadCategories();
        loadPayments();

        // Add product event listeners for existing products
        addProductEventListeners();
    });

    // Load sample products data
    function loadProducts() {
        const products = [
            {
                id: 1,
                name: "Wireless Headphones",
                category: "electronics",
                price: 129.99,
                stock: 45,
                status: "in stock",
                image: "https://placehold.co/60x60/7c3aed/fff?text=WH"
            },
            {
                id: 2,
                name: "Smart Watch",
                category: "electronics",
                price: 249.99,
                stock: 12,
                status: "low stock",
                image: "https://placehold.co/60x60/3b82f6/fff?text=SW"
            },
            {
                id: 3,
                name: "Running Shoes",
                category: "fashion",
                price: 89.99,
                stock: 78,
                status: "in stock",
                image: "https://placehold.co/60x60/10b981/fff?text=RS"
            },
            {
                id: 4,
                name: "Coffee Maker",
                category: "home",
                price: 79.99,
                stock: 0,
                status: "out of stock",
                image: "https://placehold.co/60x60/8b5cf6/fff?text=CM"
            },
            {
                id: 5,
                name: "Backpack",
                category: "fashion",
                price: 49.99,
                stock: 120,
                status: "in stock",
                image: "https://placehold.co/60x60/6366f1/fff?text=BP"
            },
            {
                id: 6,
                name: "Bluetooth Speaker",
                category: "electronics",
                price: 59.99,
                stock: 32,
                status: "in stock",
                image: "https://placehold.co/60x60/ec4899/fff?text=BS"
            },
            {
                id: 7,
                name: "Desk Lamp",
                category: "home",
                price: 34.99,
                stock: 5,
                status: "low stock",
                image: "https://placehold.co/60x60/f59e0b/fff?text=DL"
            },
            {
                id: 8,
                name: "Yoga Mat",
                category: "sports",
                price: 29.99,
                stock: 56,
                status: "in stock",
                image: "https://placehold.co/60x60/ef4444/fff?text=YM"
            }
        ];

        const productTableBody = document.getElementById('productTableBody');

        if (productTableBody) {
            productTableBody.innerHTML = '';

            products.forEach(product => {
                const statusClass = product.status === 'in stock' ? 'success' :
                    product.status === 'low stock' ? 'warning' : 'danger';

                const row = document.createElement('tr');
                row.innerHTML = `
                <td><img src="${product.image}" alt="${product.name}" class="rounded" width="40" height="40"></td>
                <td>${product.name}</td>
                <td>${product.category.charAt(0).toUpperCase() + product.category.slice(1)}</td>
                <td>$${product.price.toFixed(2)}</td>
                <td>${product.stock}</td>
                <td><span class="badge bg-${statusClass}">${product.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary edit-product" data-bs-toggle="modal" data-bs-target="#addProductModal" data-id="${product.id}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger delete-product" data-id="${product.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

                productTableBody.appendChild(row);
            });
        }
    }

    // Load sample orders data
    function loadOrders() {
        const orders = [
            { id: "ORD-7841", customer: "John Smith", date: "May 15, 2023", items: 2, amount: 249.99, status: "delivered" },
            { id: "ORD-7840", customer: "Sarah Johnson", date: "May 14, 2023", items: 1, amount: 129.99, status: "pending" },
            { id: "ORD-7839", customer: "Michael Brown", date: "May 13, 2023", items: 3, amount: 89.99, status: "shipped" },
            { id: "ORD-7838", customer: "Emily Davis", date: "May 12, 2023", items: 1, amount: 199.99, status: "cancelled" },
            { id: "ORD-7837", customer: "Robert Wilson", date: "May 11, 2023", items: 2, amount: 149.99, status: "delivered" },
            { id: "ORD-7836", customer: "Jennifer Lee", date: "May 10, 2023", items: 4, amount: 329.99, status: "delivered" },
            { id: "ORD-7835", customer: "David Miller", date: "May 9, 2023", items: 1, amount: 79.99, status: "shipped" },
            { id: "ORD-7834", customer: "Lisa Taylor", date: "May 8, 2023", items: 2, amount: 119.99, status: "pending" }
        ];

        const orderTableBody = document.getElementById('orderTableBody');

        if (orderTableBody) {
            orderTableBody.innerHTML = '';

            orders.forEach(order => {
                let statusClass, statusText;
                switch(order.status) {
                    case 'pending': statusClass = 'warning'; statusText = 'Pending'; break;
                    case 'shipped': statusClass = 'info'; statusText = 'Shipped'; break;
                    case 'delivered': statusClass = 'success'; statusText = 'Delivered'; break;
                    case 'cancelled': statusClass = 'danger'; statusText = 'Cancelled'; break;
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${order.id}</td>
                <td>${order.customer}</td>
                <td>${order.date}</td>
                <td>${order.items}</td>
                <td>$${order.amount.toFixed(2)}</td>
                <td><span class="badge bg-${statusClass}">${statusText}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary">View</button>
                </td>
            `;

                orderTableBody.appendChild(row);
            });
        }
    }

    // Load sample customers data
    function loadCustomers() {
        const customers = [
            { id: "CUST-1001", name: "John Smith", email: "john.smith@example.com", phone: "+1 (555) 123-4567", orders: 12, totalSpent: 1249.99 },
            { id: "CUST-1002", name: "Sarah Johnson", email: "sarah.j@example.com", phone: "+1 (555) 234-5678", orders: 8, totalSpent: 899.99 },
            { id: "CUST-1003", name: "Michael Brown", email: "m.brown@example.com", phone: "+1 (555) 345-6789", orders: 15, totalSpent: 1899.99 },
            { id: "CUST-1004", name: "Emily Davis", email: "emily.davis@example.com", phone: "+1 (555) 456-7890", orders: 5, totalSpent: 599.99 },
            { id: "CUST-1005", name: "Robert Wilson", email: "robert.w@example.com", phone: "+1 (555) 567-8901", orders: 22, totalSpent: 2499.99 },
            { id: "CUST-1006", name: "Jennifer Lee", email: "j.lee@example.com", phone: "+1 (555) 678-9012", orders: 9, totalSpent: 1099.99 },
            { id: "CUST-1007", name: "David Miller", email: "d.miller@example.com", phone: "+1 (555) 789-0123", orders: 3, totalSpent: 349.99 },
            { id: "CUST-1008", name: "Lisa Taylor", email: "lisa.t@example.com", phone: "+1 (555) 890-1234", orders: 17, totalSpent: 1999.99 }
        ];

        const customerTableBody = document.getElementById('customerTableBody');

        if (customerTableBody) {
            customerTableBody.innerHTML = '';

            customers.forEach(customer => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${customer.id}</td>
                <td>${customer.name}</td>
                <td>${customer.email}</td>
                <td>${customer.phone}</td>
                <td>${customer.orders}</td>
                <td>$${customer.totalSpent.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-info">
                        <i class="fas fa-envelope"></i>
                    </button>
                </td>
            `;

                customerTableBody.appendChild(row);
            });
        }
    }

    // Load sample categories data
    function loadCategories() {
        const categories = [
            { id: 1, name: "Electronics", description: "Electronic devices and accessories", products: 45, status: "active" },
            { id: 2, name: "Fashion", description: "Clothing, shoes, and accessories", products: 128, status: "active" },
            { id: 3, name: "Home & Kitchen", description: "Home appliances and kitchenware", products: 67, status: "active" },
            { id: 4, name: "Books", description: "Books and educational materials", products: 89, status: "active" },
            { id: 5, name: "Sports & Outdoors", description: "Sports equipment and outdoor gear", products: 34, status: "active" },
            { id: 6, name: "Toys & Games", description: "Toys and games for all ages", products: 56, status: "inactive" }
        ];

        const categoryTableBody = document.getElementById('categoryTableBody');

        if (categoryTableBody) {
            categoryTableBody.innerHTML = '';

            categories.forEach(category => {
                const statusClass = category.status === 'active' ? 'success' : 'danger';

                const row = document.createElement('tr');
                row.innerHTML = `
                <td>CAT-${category.id.toString().padStart(4, '0')}</td>
                <td>${category.name}</td>
                <td>${category.products}</td>
                <td><span class="badge bg-${statusClass}">${category.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

                categoryTableBody.appendChild(row);
            });
        }
    }

    // Load sample payments data
    function loadPayments() {
        const payments = [
            { id: "TXN-784101", orderId: "ORD-7841", customer: "John Smith", date: "May 15, 2023", amount: 249.99, method: "Credit Card", status: "successful" },
            { id: "TXN-784001", orderId: "ORD-7840", customer: "Sarah Johnson", date: "May 14, 2023", amount: 129.99, method: "PayPal", status: "pending" },
            { id: "TXN-783901", orderId: "ORD-7839", customer: "Michael Brown", date: "May 13, 2023", amount: 89.99, method: "Credit Card", status: "successful" },
            { id: "TXN-783801", orderId: "ORD-7838", customer: "Emily Davis", date: "May 12, 2023", amount: 199.99, method: "Stripe", status: "failed" },
            { id: "TXN-783701", orderId: "ORD-7837", customer: "Robert Wilson", date: "May 11, 2023", amount: 149.99, method: "Credit Card", status: "successful" },
            { id: "TXN-783601", orderId: "ORD-7836", customer: "Jennifer Lee", date: "May 10, 2023", amount: 329.99, method: "PayPal", status: "successful" },
            { id: "TXN-783501", orderId: "ORD-7835", customer: "David Miller", date: "May 9, 2023", amount: 79.99, method: "Stripe", status: "successful" },
            { id: "TXN-783401", orderId: "ORD-7834", customer: "Lisa Taylor", date: "May 8, 2023", amount: 119.99, method: "Credit Card", status: "pending" }
        ];

        const paymentTableBody = document.getElementById('paymentTableBody');

        if (paymentTableBody) {
            paymentTableBody.innerHTML = '';

            payments.forEach(payment => {
                let statusClass, statusText;
                switch(payment.status) {
                    case 'successful': statusClass = 'success'; statusText = 'Successful'; break;
                    case 'pending': statusClass = 'warning'; statusText = 'Pending'; break;
                    case 'failed': statusClass = 'danger'; statusText = 'Failed'; break;
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${payment.id}</td>
                <td>${payment.orderId}</td>
                <td>${payment.customer}</td>
                <td>${payment.date}</td>
                <td>$${payment.amount.toFixed(2)}</td>
                <td>${payment.method}</td>
                <td><span class="badge bg-${statusClass}">${statusText}</span></td>
            `;

                paymentTableBody.appendChild(row);
            });
        }
    }
</script>
<script>
    // Chart.js initialization for sales analytics

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize sales chart
        const salesChartCanvas = document.getElementById('salesChart');

        if (salesChartCanvas) {
            const ctx = salesChartCanvas.getContext('2d');

            // Chart data
            const salesData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Sales',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 30000, 40000, 38000, 45000],
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124, 58, 237, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Revenue',
                        data: [8000, 12000, 10000, 18000, 15000, 22000, 20000, 28000, 25000, 32000, 30000, 38000],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            };

            // Get computed styles for theme
            const computedStyle = getComputedStyle(document.documentElement);
            const textColor = computedStyle.getPropertyValue('--dark-color').trim();
            const gridColor = computedStyle.getPropertyValue('--gray-light').trim();
            const mutedColor = computedStyle.getPropertyValue('--gray-color').trim();

            // Chart configuration
            const config = {
                type: 'line',
                data: salesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: textColor,
                                font: {
                                    size: 14
                                },
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 14
                            },
                            padding: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: true,
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: mutedColor,
                                font: {
                                    size: 12
                                },
                                maxRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: mutedColor,
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    if (value >= 1000) {
                                        return '$' + (value / 1000).toFixed(0) + 'k';
                                    }
                                    return '$' + value;
                                },
                                padding: 10
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'nearest'
                    },
                    elements: {
                        line: {
                            tension: 0.4
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            right: 10,
                            bottom: 10,
                            left: 10
                        }
                    }
                }
            };

            // Create the chart
            const salesChart = new Chart(ctx, config);

            // Handle window resize
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    salesChart.resize();
                }, 250);
            });

            // Update chart colors on dark mode toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('change', function() {
                    const isDarkMode = this.checked;

                    // Update colors based on theme
                    setTimeout(() => {
                        const updatedTextColor = getComputedStyle(document.documentElement).getPropertyValue('--dark-color').trim();
                        const updatedGridColor = getComputedStyle(document.documentElement).getPropertyValue('--gray-light').trim();
                        const updatedMutedColor = getComputedStyle(document.documentElement).getPropertyValue('--gray-color').trim();

                        salesChart.options.plugins.legend.labels.color = updatedTextColor;
                        salesChart.options.scales.x.ticks.color = updatedMutedColor;
                        salesChart.options.scales.y.ticks.color = updatedMutedColor;
                        salesChart.options.scales.x.grid.color = updatedGridColor;
                        salesChart.options.scales.y.grid.color = updatedGridColor;

                        salesChart.update('none');
                    }, 100);
                });
            }
        }
    });
</script>
