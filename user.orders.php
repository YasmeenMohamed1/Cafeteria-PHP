<?php (@include ("./layouts/header.php")) or die(" file not exist"); ?>
<?php (@include ("./layouts/admin.nav.php")) or die(" file not exist"); ?>


    <style>
        .order-details {
            display: none;
        }
        .order-date {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
       
        .table {
            border: 1px solid #2f170fe6;
            background-color:#f1e7d8;
            color:#2f170fe6;
        }
        .table th, .table td {
            border: 1px solid #2f170fe6;
        }
        .order-items {
            display: flex;
        }
      
    </style>

    <div class="container">
        <h1 class="mt-4">My Orders</h1>
        <div class="row">
            <div class="col-md-6 text-center">
                <form>
                    <label for="dateFrom">Date From:</label>
                    <input type="date" id="dateFrom" name="dateFrom">
                </form>
            </div>
            <div class="col-md-6 text-center">
                <form>
                    <label for="dateTo">Date To:</label>
                    <input type="date" id="dateTo" name="dateTo">
                </form>
            </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="order-date-row">
                    <td class="order-date">
                        <div class="d-flex align-items-center">
                            <div>2024-04-01</div>
                            <div class="toggle-btn">+</div>
                        </div>
                    </td>
                    <td>Status 1</td>
                    <td>$100</td>
                    <td>Action 1</td>
                </tr>
                <tr class="order-details" style="display: none;">
                    <td colspan="4">
                        <div class="order-items">
                            <div>Item 1</div>
                            <div>Item 2</div>
                            <div>Item 3</div>
                        </div>
                    </td>
                </tr>
                <tr class="order-date-row">
                    <td class="order-date">
                        <div class="d-flex align-items-center">
                            <span>2024-04-01</span>
                            <span class="toggle-btn">+</span>
                        </div>
                    </td>
                    <td>Status 1</td>
                    <td>$100</td>
                    <td>Action 1</td>
                </tr>
                <tr class="order-details" style="display: none;">
                    <td colspan="4">
                        <div class="order-items">
                            <div>Item 1</div>
                            <div>Item 2</div>
                            <div>Item 3</div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const row = btn.closest('.order-date-row').nextElementSibling;
                row.style.display = (row.style.display === 'none' || row.style.display === '') ? 'table-row' : 'none';
                btn.textContent = (btn.textContent === '+') ? '-' : '+';
            });
        });
    </script>

<?php (@include ("./layouts/footer.php")) or die(" file not exist"); ?>
