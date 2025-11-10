<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password | Graduation Projects E-Library</title>

  <!-- CSS Links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../icomoon/icomoon.css">
  <link rel="stylesheet" href="../css/vendor.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../css/dark-mode.css">
  <link rel="stylesheet" href="../css/login-dark-mode.css">

  <style>
    body {
      background-color: var(--light-color);
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      max-width: 500px;
      margin: 5rem auto;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .card h3 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #333;
      border-bottom: 2px solid rgb(154, 136, 76);
      padding-bottom: 8px;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-intro {
      color: #9a884c;
      font-size: 0.95rem;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .reset-form input[type="text"],
    .reset-form input[type="email"],
    .reset-form input[type="password"] {
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

    .reset-form input:focus {
      border-bottom: 2px solid rgb(154, 136, 76);
      outline: none !important;
      box-shadow: none !important;
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

    .feedback {
      font-size: 0.9rem;
      margin-top: -1rem;
      margin-bottom: 1rem;
    }

    .feedback.error {
      color: red;
    }

    .feedback.success {
      color: green;
    }

    .input-error {
      border-bottom: 2px solid red !important;
      animation: shake 0.3s ease;
    }

    .input-success {
      border-bottom: 2px solid green !important;
    }

    @keyframes shake {
      0% { transform: translateX(0); }
      25% { transform: translateX(-4px); }
      50% { transform: translateX(4px); }
      75% { transform: translateX(-4px); }
      100% { transform: translateX(0); }
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
  </style>
</head>
<body>

  <section id="reset-password" class="py-5 my-5">
    <div class="card shadow-sm p-4 rounded-4" data-aos="fade-up">
      <h3>Reset Password</h3>
      <p class="form-intro">Choose your role and enter your credentials to reset your password.</p>

      <div class="login-tabs nav nav-pills justify-content-center mb-4">
        <button class="nav-link active" onclick="switchType('student')">Student</button>
        <button class="nav-link" onclick="switchType('faculty')">Instructor</button>
        <button class="nav-link" onclick="switchType('admin')">Admin</button>
      </div>

      <form id="resetForm" class="reset-form" action="../backend/process-forgot.php" method="POST">
        <div id="inputContainer">
          <input type="text" name="student_id" placeholder="Academic ID" required>
        </div>

        <input type="password" name="new_password" id="new_password" placeholder="New Password" required>
        <div id="strengthFeedback" class="feedback"></div>

        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
        <div id="matchFeedback" class="feedback"></div>

        <input type="hidden" name="type" id="userType" value="student">

        <div class="text-center mt-3">
          <button type="submit" class="btn-login">Reset Password</button>
        </div>
      </form>
    </div>
  </section>

  <script>
    function switchType(type) {
      document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
      document.querySelector(`.nav-link[onclick="switchType('${type}')"]`).classList.add('active');

      const inputContainer = document.getElementById('inputContainer');
      const userType = document.getElementById('userType');
      userType.value = type;

      if (type === 'student') {
        inputContainer.innerHTML = `<input type="text" name="student_id" placeholder="Academic ID" required>`;
      } else if (type === 'faculty') {
        inputContainer.innerHTML = `<input type="email" name="faculty_email" placeholder="University Email" required>`;
      } else {
        inputContainer.innerHTML = `<input type="text" name="admin_user" placeholder="Admin Username" required>`;
      }
    }

    const pwd = document.getElementById('new_password');
    const confirm = document.getElementById('confirm_password');
    const feedbackStrength = document.getElementById('strengthFeedback');
    const feedbackMatch = document.getElementById('matchFeedback');

    function validatePassword(p) {
      return p.length >= 8 &&
             /[A-Z]/.test(p) &&
             /[a-z]/.test(p) &&
             /[0-9]/.test(p) &&
             /[\W]/.test(p);
    }

    pwd.addEventListener('input', () => {
      if (validatePassword(pwd.value)) {
        pwd.classList.remove('input-error');
        pwd.classList.add('input-success');
        feedbackStrength.textContent = "Strong password ✅";
        feedbackStrength.className = "feedback success";
      } else {
        pwd.classList.remove('input-success');
        pwd.classList.add('input-error');
        feedbackStrength.textContent = "Password must be 8+ characters and include uppercase, lowercase, number, and symbol.";
        feedbackStrength.className = "feedback error";
      }
    });

    confirm.addEventListener('input', () => {
      if (confirm.value === pwd.value) {
        confirm.classList.remove('input-error');
        confirm.classList.add('input-success');
        feedbackMatch.textContent = "Passwords match ✅";
        feedbackMatch.className = "feedback success";
      } else {
        confirm.classList.remove('input-success');
        confirm.classList.add('input-error');
        feedbackMatch.textContent = "Passwords do not match ❌";
        feedbackMatch.className = "feedback error";
      }
    });

    document.getElementById('resetForm').addEventListener('submit', function(e) {
      if (!validatePassword(pwd.value) || pwd.value !== confirm.value) {
        e.preventDefault();
        pwd.classList.add('input-error');
        confirm.classList.add('input-error');
        alert("Please fix the errors before submitting.");
      }
    });
  </script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
