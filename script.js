document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS if you're still using it
    if (typeof AOS !== 'undefined') {
        AOS.init();
    }

    // Passkey check
    const passkeyCheckForm = document.getElementById('passkeyCheckForm');
    const passkeyForm = document.getElementById('passkeyForm');
    const registerForm = document.getElementById('registerForm');

    if (passkeyCheckForm) {
        passkeyCheckForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('verify_passkey.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    passkeyForm.classList.add('hidden');
                    registerForm.classList.remove('hidden');
                } else {
                    alert('Invalid passkey. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }

    // Admin Register form submission
    const adminRegisterForm = document.getElementById('adminRegisterForm');
    if (adminRegisterForm) {
        adminRegisterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Admin registration successful!');
                    window.location.href = 'login_page.php';
                } else {
                    alert(data.message || 'Registration failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }

     // Login form submission
     const loginForm = document.getElementById('loginForm');
     if (loginForm) {
         loginForm.addEventListener('submit', function(e) {
             e.preventDefault();
             const formData = new FormData(this);
             fetch('login.php', {
                 method: 'POST',
                 body: formData
             })
             .then(response => {
                 if (!response.ok) {
                     throw new Error('Network response was not ok');
                 }
                 return response.json();
             })
             .then(data => {
                 if (data.success) {
                     window.location.href = 'dashboard.php';
                 } else {
                     alert(data.message || 'Login failed. Please try again.');
                 }
             })
             .catch(error => {
                 console.error('Error:', error);
                 alert('An error occurred. Please try again.');
             });
         });
     }
 
     // Logout button
     const logoutBtn = document.getElementById('logoutBtn');
     if (logoutBtn) {
         logoutBtn.addEventListener('click', function() {
             fetch('logout.php', {
                 method: 'POST'
             })
             .then(response => {
                 if (!response.ok) {
                     throw new Error('Network response was not ok');
                 }
                 return response.json();
             })
             .then(data => {
                 if (data.success) {
                     window.location.href = 'login_page.php';
                 } else {
                     alert(data.message || 'Logout failed. Please try again.');
                 }
             })
             .catch(error => {
                 console.error('Error:', error);
                 alert('An error occurred. Please try again.');
             });
         });
     }
 });