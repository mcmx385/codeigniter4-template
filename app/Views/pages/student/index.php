<div class="container">
    <h1>Welcome back <?php echo $_SESSION['username']; ?>!</h1>
    <a href="/student/courses" class="btn btn-primary btn-lg">View your <?php echo $data['count']; ?> courses</a>
</div>