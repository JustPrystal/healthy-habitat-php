<div class="dashboard-content add-new-product">
  <header class="header">
    <div class="inner">
      <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="113" height="50" viewBox="0 0 113 50" fill="none">
        <path d="M12.16 26.16V50H0.8V0.559998H12.16V24.32H24.24V0.559998H35.6V50H24.24V26.16H12.16ZM52.5506 26.16V50H41.1906V0.559998H52.5506V24.32H64.6306V0.559998H75.9906V50H64.6306V26.16H52.5506ZM83.2613 8.08V33.68C83.3146 35.0133 83.8213 36.2933 84.7813 37.52C85.7946 38.6933 86.8879 39.92 88.0613 41.2C89.2346 42.48 90.3013 43.84 91.2613 45.28C92.2213 46.6667 92.7013 48.24 92.7013 50H81.5813V0.559998H91.4213L110.461 42V16.8C110.408 15.4667 109.875 14.2133 108.861 13.04C107.901 11.8133 106.835 10.5867 105.661 9.36C104.488 8.08 103.421 6.74667 102.461 5.36C101.501 3.92 101.021 2.32 101.021 0.559998H112.141V50H102.621L83.2613 8.08Z" fill="#134027" />
      </svg>
      <h3 class="author-name">BreatheWell Studio</h3>
      <div class="hamburger-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--charm icon" width="1em" height="1em" viewBox="0 0 16 16">
          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.75 12.25h10.5m-10.5-4h10.5m-10.5-4h10.5"></path>
        </svg>
      </div>
    </div>
  </header>
  <div class="inner">
    <h2 class="content-main-heading">
      Add New Product/Service
    </h2>
    <div class="form-container">
      <form action="">
        <div class="input-wrap name">
          <label for="name">Name of Product/Service </label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="input-wrap type">
          <span class="type-label">Type</span>
          <div class="radio-wrap">
            <div class="field-wrap">
              <input type="radio" id="product" name="type" value="product" required>
              <label for="product">product</label>
            </div>
            <div class="field-wrap">
              <input type="radio" id="service" name="type" value="product" required>
              <label for="service">service</label>
            </div>
          </div>
        </div>
        <div class="input-wrap category">
          <label for="category">Category</label>
          <select name="category" id="category" required>
            <option value="" disabled selected>Category e.g., Organic Personal Care</option>
            <option value="lorem ipsum">lorem ipsum</option>
            <option value="lorem ipsum">lorem ipsum</option>
          </select>
        </div>
        <div class="input-wrap price">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" required>
        </div>
        <div class="input-wrap">
          <label for="description">description</label>
          <textarea name="description" id="description"></textarea>
        </div>
        <div class="input-wrap">
          <label for="health-benefits">health benifits</label>
          <textarea name="health-benefits" id="health-benefits"></textarea>
        </div>
        <div class="input-wrap upload">
          <span class="upload-label">images upload</span>
          <label class="upload" for="img">
            <svg xmlns="http://www.w3.org/2000/svg" width="58" height="54" viewBox="0 0 58 54" fill="none">
              <g opacity="0.7">
                <path d="M55.9583 29.7083V16.5833C55.9583 12.7156 54.4219 9.00626 51.687 6.27136C48.9521 3.53645 45.2427 2 41.375 2H16.5833C12.7156 2 9.00626 3.53645 6.27136 6.27136C3.53645 9.00626 2 12.7156 2 16.5833V37C2 38.9151 2.37721 40.8115 3.11009 42.5808C3.84297 44.3501 4.91717 45.9578 6.27136 47.312C9.00626 50.0469 12.7156 51.5833 16.5833 51.5833H34.8417" stroke="#134027" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M2.75879 41.3748L10.7505 32.0414C11.8 30.999 13.1774 30.3513 14.6497 30.2078C16.1219 30.0643 17.5985 30.4338 18.8296 31.2539C20.0607 32.074 21.5373 32.4436 23.0096 32.3001C24.4818 32.1566 25.8593 31.5088 26.9088 30.4664L33.7046 23.6706C35.6573 21.7113 38.2427 20.5095 40.9993 20.2798C43.756 20.0501 46.5046 20.8073 48.7546 22.4164L55.9588 27.9873M17.3421 21.4539C17.9779 21.4501 18.6068 21.3211 19.1927 21.0742C19.7787 20.8274 20.3103 20.4675 20.7572 20.0152C21.204 19.5629 21.5575 19.027 21.7972 18.4381C22.037 17.8493 22.1585 17.2189 22.1546 16.5831C22.1508 15.9473 22.0218 15.3184 21.7749 14.7325C21.5281 14.1465 21.1682 13.6149 20.7159 13.1681C20.2636 12.7212 19.7277 12.3678 19.1388 12.128C18.55 11.8882 17.9196 11.7668 17.2838 11.7706C15.9997 11.7783 14.7713 12.2959 13.8688 13.2093C12.9662 14.1228 12.4636 15.3573 12.4713 16.6414C12.479 17.9255 12.9965 19.1539 13.91 20.0565C14.8235 20.959 16.058 21.4617 17.3421 21.4539Z" stroke="#134027" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M48.541 35.542V50.1253" stroke="#134027" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" />
                <path d="M55.2294 41.681L49.4923 35.9439C49.3676 35.8187 49.2194 35.7193 49.0563 35.6515C48.8931 35.5837 48.7181 35.5488 48.5414 35.5488C48.3647 35.5488 48.1898 35.5837 48.0266 35.6515C47.8634 35.7193 47.7153 35.8187 47.5906 35.9439L41.8535 41.681" stroke="#134027" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
              </g>
            </svg>
            <span>Upload high quality images to present your product/service.</span>
          </label>
          <input type="file" id="img" name="img" accept="image/*" required>
        </div>
        <div class="input-wrap">
          <button type="submit">submit</button>
        </div>
      </form>
    </div>
  </div>

</div>