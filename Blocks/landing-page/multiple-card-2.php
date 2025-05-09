<section class="multiple-cards-section" id="solutions">
    <div class="inner">
        <h2 class="heading">
            Curated Solutions for a Healthier Life
        </h2>
        <p class="text">
            Explore eco-conscious and health-first solutions chosen to improve your everyday well-being. Each solution
            is crafted with care for you and the planet.
        </p>
        <div class="content-wrap">
            <div class="filter-wrap">
                <div class="input-wrap">
                    <input type="text" name="catgories" id="catgories"
                        placeholder="E.g., 'Bamboo Towels', 'Air Purifier', 'Deodorant'">
                    <label for="catgories"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                            viewBox="0 0 22 22" fill="none">
                            <path
                                d="M15.1453 15.1453C15.9102 14.3804 16.5169 13.4723 16.9309 12.4729C17.3448 11.4736 17.5579 10.4024 17.5579 9.3207C17.5579 8.23898 17.3448 7.16784 16.9309 6.16846C16.5169 5.16908 15.9102 4.26101 15.1453 3.49612C14.3804 2.73122 13.4723 2.12447 12.4729 1.71052C11.4736 1.29656 10.4024 1.0835 9.3207 1.0835C8.23898 1.0835 7.16784 1.29656 6.16846 1.71052C5.16908 2.12447 4.26101 2.73122 3.49612 3.49612C1.95134 5.04089 1.0835 7.13606 1.0835 9.3207C1.0835 11.5053 1.95134 13.6005 3.49612 15.1453C5.04089 16.6901 7.13606 17.5579 9.3207 17.5579C11.5053 17.5579 13.6005 16.6901 15.1453 15.1453ZM15.1453 15.1453L20.3335 20.3335"
                                stroke="#134027" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg></label>
                </div>
                <div class="button-wrap">
                    <div class="checkbox-wrap">
                        <input id="price-check" name="price-range" type="checkbox" value="price">
                        <label for="price-range">Under £<span id="price-label">200</span></label>
                    </div>
                    <div class="filter" id="product-filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                            <path d="M1.5 1H16.5M4 6H14M7 11H11" stroke="#134027" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <select name="filter-type" class="select-filter" id="type-filter">
                            <option value="all" selected>Filters</option>
                            <option value="product">Products</option>
                            <option value="service">Services</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div id="product-card-grid" class="content">
            
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('type-filter');
        const priceCheck = document.getElementById('price-check');
        const searchInput = document.getElementById('catgories');

        function applyFilters() {
            const selectedType = select.value;
            const priceChecked = priceCheck.checked;
            const search = searchInput.value.toLowerCase();

            const rawText = document.getElementById('price-label').textContent;
            const numericPrice = parseFloat(rawText.replace(/[^\d.]/g, ''));

            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                const type = card.dataset.type;
                const price = parseFloat(card.dataset.price);
                const title = card.querySelector('.heading')?.textContent.toLowerCase() || '';
                const description = card.querySelector('.description')?.textContent.toLowerCase() || '';
                const category = card.querySelector('.category')?.textContent.toLowerCase() || '';
                const offerBy = card.querySelector('.creator-name')?.textContent.toLowerCase() || '';

                const matchesPrice = !priceChecked || price <= numericPrice;
                const matchesSearch =
                    title.includes(search) ||
                    description.includes(search) ||
                    category.includes(search) ||
                    offerBy.includes(search);

                const shouldShow = matchesPrice && matchesSearch;

                card.style.display = shouldShow ? 'flex' : 'none';
            });
        }

        function loadCards() {
            const selectedType = select.value;

            $.get(`./Blocks/sme/get_product_cards.php?type=${encodeURIComponent(selectedType)}`, function (data) {
                $("#product-card-grid").html(data);
                applyFilters(); // Re-apply filters to the newly loaded cards
            });
        }

        // Initial load
        loadCards();

        // Re-load cards and re-filter on type change
        select.addEventListener('change', () => {
            loadCards();
        });

        // Filter only (no reload needed)
        priceCheck.addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);
    });


</script>