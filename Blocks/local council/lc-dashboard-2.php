<div class="dashboard-content add-new-area-form">
  <div class="inner">
    <h2 class="content-main-heading">
      Add New Area Form
    </h2>
    <div class="lc-form-container">
      <form action="./Blocks/local council/add-locations.php" method="POST">  
        <div class="input-wrap name">
          <label for="name">Area Name </label>
          <input type="text" id="name" name="name" placeholder='e.g., “Northbridge”, “Harrow South”' required>
        </div>
        <div class="input-wrap type">
          <label for="zip">Postal Code / Area Code</label>
          <input type="text" id="zip" name="zip" pattern="[0-9]*" required>
        </div>
        <div class="input-wrap category">
          <label for="category">Region / County / Province</label>
          <select name="category" id="category" required>
            <option value="" disabled selected>E.g., Greater London, West Yorkshire, Lancashire</option>
            <option value="bedfordshire">Bedfordshire</option>
            <option value="berkshire">Berkshire</option>
            <option value="bristol">Bristol</option>
            <option value="buckinghamshire">Buckinghamshire</option>
            <option value="Cambridgeshire">Cambridgeshire</option>
            <option value="cheshire">Cheshire</option>
          </select>
        </div>
        <div class="input-wrap">
          <label for="description">Brief Description</label>
          <textarea name="description" id="description" placeholder='"Suburban neighborhood focused on sustainable housing"'></textarea>
        </div>
        <div class="input-wrap">
          <button type="submit">Add Area</button>
        </div>
      </form>
    </div>
  </div>

</div>