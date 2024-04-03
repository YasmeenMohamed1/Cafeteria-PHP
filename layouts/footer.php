<footer class="footer text-faded text-center py-5">
    <div class="container">
        <p class="m-0 small">Copyright &copy; Your Website 2023</p>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
 <!-- Core theme JS-->
<script src="../assets/js/scripts.js"></script>

<script>
    function updateExt(select) {
        var selectedRoomNo = select.value;
        var extInput = document.getElementById('exampleFormControlInput3');
        // Update the disabled property of the input based on the selected room number
        if (selectedRoomNo == 101 || selectedRoomNo == 102 || selectedRoomNo == 105 ) {
            extInput.value = 1;
        } else if(selectedRoomNo == 103 || selectedRoomNo == 104 ){
            extInput.value = 2;
        }
    }
</script>

</body>

</html>