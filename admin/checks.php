<?php
(@include ("../layouts/header.php")) or die("Header file does not exist");
(@include ("../layouts/admin.nav.php")) or die("Admin navigation file does not exist");
?>

<style>
    .inner-table {
        width: 100%;
    }
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
    <h1 class="mt-4">Checks</h1>
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
        <select class="col-md-6 text-center" id="select" name="select" required>
                            <option value="">Select User</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['user_name']; ?>"><?php echo $user['user_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr class="order-date-row order-row">
                <td class="order-name">
                    <div class="d-flex align-items-center">
                    <span class="toggle-btn btn btn-primary">+</span>    
                    <span>Name 1</span>
                    </div>
                </td>
                <td>$100</td>
            </tr>
            <tr class="order-details" style="display: none;">
                <td colspan="2">
                    <table class="inner-table">
                        <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order-date-row">
                                <td>
                                    <div class="d-flex align-items-center">
                                    <span class="toggle-btn toggle-date-btn btn btn-primary">+</span>    
                                    <span>2024-04-01</span>
                                    </div>
                                </td>
                                <td>Account 1</td>
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
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const detailsRow = btn.closest('.order-row').nextElementSibling;
            detailsRow.style.display = (detailsRow.style.display === 'none' || detailsRow.style.display === '') ? 'table-row' : 'none';
            btn.textContent = (btn.textContent === '+') ? '-' : '+';
        });
    });

    document.querySelectorAll('.toggle-date-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const itemsRow = btn.closest('.order-date-row').nextElementSibling;
            itemsRow.style.display = (itemsRow.style.display === 'none' || itemsRow.style.display === '') ? 'table-row' : 'none';
            btn.textContent = (btn.textContent === '+') ? '-' : '+';
        });
    });
</script>
<?php (@include ("../layouts/footer.php")) or die(" file not exist"); ?>
