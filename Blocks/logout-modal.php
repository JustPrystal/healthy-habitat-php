<div id="logout-modal" class="logout-modal hidden">
  <div class="logout-card">
    <h2>Are you sure you want to logout?</h2>
    <div class="logout-buttons">
      <form action="logout.php" method="POST">
        <button type="submit" class="btn logout">Yes</button>
      </form>
      <button type="button" id="cancel-btn" class="btn cancel">No</button>
    </div>
  </div>
</div>
<script>
document.getElementById('logout-link').addEventListener('click', function(event) {
  event.preventDefault();
  document.getElementById('logout-modal').classList.remove('hidden');
});

document.getElementById('cancel-btn').addEventListener('click', function() {
  document.getElementById('logout-modal').classList.add('hidden');
});
</script>