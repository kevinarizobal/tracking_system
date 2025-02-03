<style>
/* Basic reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Ensure the body takes at least 100% height and has space for the footer */
body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  padding-bottom: 60px; /* Space for the footer */
}

/* Main content styling */
.content {
  flex: 1; /* Take remaining space */
  padding: 20px;
}

/* Footer styling */
footer {
  background-color: #316cf4;
  color: white;
  padding: 20px 0;
  text-align: center;
  position: fixed;
  bottom: 0;
  width: 100%;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
}

.footer-links a {
  color: white;
  text-decoration: none;
  margin: 0 10px;
}

.footer-links a:hover {
  text-decoration: underline;
}

</style>

<footer>
    <div class="footer-container">
      <small>&copy; 2024 NEMSU Cantilan. All Rights Reserved.</small>
      <div class="footer-links">
        <a href="#">Privacy Policy</a> | 
        <a href="#">Terms of Service</a> | 
        <a href="#">Contact Us</a>
      </div>
    </div>
  </footer>
