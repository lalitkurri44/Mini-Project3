


document.addEventListener('DOMContentLoaded', function () {
    // Dummy Data (Replace with real data later)
    const years = [2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024];
    
    // 1. Sales Trend
    const salesTrendCtx = document.getElementById('salesTrend').getContext('2d');
    new Chart(salesTrendCtx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Sales ($)',
                data: [50000, 65000, 72000, 85000, 90000, 105000, 110000, 125000, 140000, 160000, 175000],
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79,70,229,0.2)',
                tension: 0.3
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // 2. Customer Source
    const customerSourceCtx = document.getElementById('customerSource').getContext('2d');
    new Chart(customerSourceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Organic', 'Referral', 'Paid Ads', 'Social Media'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#4f46e5','#6366f1','#a78bfa','#c4b5fd']
            }]
        },
        options: { responsive: true }
    });

    // 3. Sales by City
    const salesCityCtx = document.getElementById('salesCity').getContext('2d');
    new Chart(salesCityCtx, {
        type: 'bar',
        data: {
            labels: ['New York','Los Angeles','Chicago','Houston','Phoenix'],
            datasets: [{
                label: 'Sales ($)',
                data: [50000, 40000, 30000, 20000, 15000],
                backgroundColor: '#4f46e5'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // 4. Sales by Service Type
    const salesServiceCtx = document.getElementById('salesService').getContext('2d');
    new Chart(salesServiceCtx, {
        type: 'pie',
        data: {
            labels: ['Consulting','Software','Hardware','Support'],
            datasets: [{
                data: [40,30,20,10],
                backgroundColor: ['#4f46e5','#818cf8','#a5b4fc','#c7d2fe']
            }]
        },
        options: { responsive: true }
    });

    // 5. Department Margin
    const deptMarginCtx = document.getElementById('deptMargin').getContext('2d');
    new Chart(deptMarginCtx, {
        type: 'bar',
        data: {
            labels: ['Sales','Marketing','HR','Finance','IT'],
            datasets: [{
                label: 'Margin ($)',
                data: [20000,15000,8000,12000,10000],
                backgroundColor: '#4f46e5'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // 6. New vs Repeat Sales
    const newRepeatCtx = document.getElementById('newRepeat').getContext('2d');
    new Chart(newRepeatCtx, {
        type: 'doughnut',
        data: {
            labels: ['New','Repeat'],
            datasets: [{
                data: [92,148],
                backgroundColor: ['#4f46e5','#818cf8']
            }]
        },
        options: { responsive: true }
    });

    // 7. Top 10 Customers
    const topCustomersCtx = document.getElementById('topCustomers').getContext('2d');
    new Chart(topCustomersCtx, {
        type: 'bar',
        data: {
            labels: ['Customer A','B','C','D','E','F','G','H','I','J'],
            datasets: [{
                label: 'Sales ($)',
                data: [20000,18000,16000,15000,14000,13000,12000,11000,10000,9000],
                backgroundColor: '#4f46e5'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
});
