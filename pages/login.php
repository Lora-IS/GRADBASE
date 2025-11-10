
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Graduation Projects E-Library</title>

  <!-- CSS Links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../icomoon/icomoon.css">
  <link rel="stylesheet" href="../css/vendor.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../css/dark-mode.css">
  <link rel="stylesheet" href="../css/login-dark-mode.css">

  <style>
    .card h3 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #333;
      border-bottom: 2px solid rgb(154, 136, 76);
      padding-bottom: 8px;
      margin-bottom: 1.5rem;
    }

    .login-tabs .nav-link {
      font-weight: 600;
      color: #333;
      border: 2px solid rgb(154, 136, 76);
      border-radius: 30px;
      padding: 10px 20px;
      margin: 0 10px;
      background-color: transparent;
      transition: all 0.3s ease;
    }

    .login-tabs .nav-link.active {
      background-color: rgb(154, 136, 76);
      color: white;
    }

    .btn-login {
      background-color: rgb(154, 136, 76);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 30px;
      font-weight: bold;
      font-size: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
      background-color: #a48f56;
    }

    .login-form {
      display: none;
      transition: opacity 0.3s ease;
      opacity: 0;
    }

    .login-form.active {
      display: block;
      opacity: 1;
    }

    .login-form input[type="text"],
    .login-form input[type="email"],
    .login-form input[type="password"] {
      all: unset;
      width: 100%;
      border-bottom: 2px solid #ccc;
      padding: 10px 0;
      margin-bottom: 1.5rem;
      font-size: 1rem;
      font-family: inherit;
      color: #333;
      background-color: transparent;
      transition: border-bottom-color 0.3s ease;
    }

    .login-form input:focus {
      border-bottom: 2px solid rgb(154, 136, 76);
      outline: none !important;
      box-shadow: none !important;
    }
  </style>
</head>

<body>
  <section id="login" class="py-5 my-5">
    <div class="card shadow-sm p-4 rounded-4" style="max-width: 500px; margin: auto;" data-aos="fade-up">
      <h3 class="text-center mb-4">Login</h3>

<?php session_start();
 if (isset($_SESSION['login_error'])) 
 { 
  echo '<div class="alert alert-danger text-center mb-3">' . htmlspecialchars($_SESSION['login_error']) . '</div>';
   unset($_SESSION['login_error']);
    } 
    ?>


      <p class="form-intro text-center" style="color:#9a884c;">
        To begin your academic journey, log in and explore your potential.
      </p>

      <div class="login-tabs nav nav-pills justify-content-center mb-4">
        <button class="nav-link active" onclick="switchForm('student')" aria-label="Login as Student">Student</button>
        <button class="nav-link" onclick="switchForm('faculty')" aria-label="Login as Faculty">Instructor</button>
        <button class="nav-link" onclick="switchForm('admin')">Admin</button> 
      </div>

      <!-- Student Login Form -->
      <form id="student-form" class="login-form active" action="../backend/login.php" method="POST" onsubmit="this.querySelector('.btn-login').disabled = true;">
        <input type="text" name="student_id" placeholder="Academic ID" autocomplete="username" required>
        <input type="password" name="student_pass" placeholder="Password" autocomplete="current-password" required>
        <input type="hidden" name="type" value="student">
          <div class="text-end mb-3">
           <a href="forgot-password.php?type=student" style="color:#9a884c; font-size: 0.9rem;">Forgot Password?</a>
          </div>
        <div class="text-center mt-3">
          <button class="btn-login" type="submit">Login</button>
        </div>
      </form>

      <!-- Faculty Login Form -->
      <form id="faculty-form" class="login-form" action="../backend/login.php" method="POST" onsubmit="this.querySelector('.btn-login').disabled = true;">
        <input type="email" name="faculty_email" placeholder="University Email" autocomplete="username" required>
        <input type="password" name="faculty_pass" placeholder="Password" autocomplete="current-password" required>
        <input type="hidden" name="type" value="faculty">
         <div class="text-end mb-3">
          <a href="forgot-password.php?type=faculty" style="color:#9a884c; font-size: 0.9rem;">Forgot Password?</a>
          </div>
        <div class="text-center mt-3">
          <button class="btn-login" type="submit">Login</button>
        </div>
      </form>
      <!-- Admin Login Form -->
       <form id="admin-form" class="login-form" action="../backend/login.php" method="POST" onsubmit="this.querySelector('.btn-login').disabled = true;">
      <input type="text" name="admin_user" placeholder="Admin Username" required>
      <input type="password" name="admin_pass" placeholder="Password" required>
      <input type="hidden" name="type" value="admin">
       <div class="text-end mb-3">
      <a href="forgot-password.php?type=admin" style="color:#9a884c; font-size: 0.9rem;">Forgot Password?</a>
      </div>
      <div class="text-center mt-3">
      <button class="btn-login" type="submit">Login</button>
  </div>
</form>

    </div>
  </section>

  <!-- JS -->
  <script>
   function switchForm(type) {
  document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.login-form').forEach(form => form.classList.remove('active'));

  if (type === 'student') {
    document.querySelector('.nav-link:nth-child(1)').classList.add('active');
    document.getElementById('student-form').classList.add('active');
  } else if (type === 'faculty') {
    document.querySelector('.nav-link:nth-child(2)').classList.add('active');
    document.getElementById('faculty-form').classList.add('active');
  } else {
    document.querySelector('.nav-link:nth-child(3)').classList.add('active');
    document.getElementById('admin-form').classList.add('active');
  }
}
  </script>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>AOS.init();</script>
  <script src="../js/dark-mode.js"></script>
</body>

</html>
