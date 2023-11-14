    <!-- Backend Bundle JavaScript -->
    <script src="<?= ASSETS_URL; ?>assets/js/backend-bundle.min.js"></script>

    <!-- Flextree Javascript-->
    <script src="<?= ASSETS_URL; ?>assets/js/flex-tree.min.js"></script>
    <script src="<?= ASSETS_URL; ?>assets/js/tree.js"></script>

    <!-- Table Treeview JavaScript -->
    <script src="<?= ASSETS_URL; ?>assets/js/table-treeview.js"></script>

    <!-- SweetAlert JavaScript -->
    <script src="<?= ASSETS_URL; ?>assets/js/sweetalert.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="<?= ASSETS_URL; ?>assets/js/chart-custom.js"></script>

    <!-- slider JavaScript -->
    <script src="<?= ASSETS_URL; ?>assets/js/slider.js"></script>

    <!-- app JavaScript -->
    <script src="<?= ASSETS_URL; ?>assets/js/app.js"></script>

    <!-- <script src="<?= ASSETS_URL;?>plugins/jquery-3.6.0.min.js"></script> -->

    <script>
        const API = `<?= APP_URL; ?>api/Auth.api`; // API URL
        const TOKEN = '<?= $token; ?>'; // Generated Token
        const CSRF_TOKEN = '<?= $_SESSION['csrf_token']; ?>'; // CSRF Token
        const CSRF_TOKEN_TIME = '<?= $_SESSION['csrf_token_time']; ?>'; // CSRF Token Time
    </script>

    <!-- SweetAlert2: https://sweetalert2.github.io/#usage -->
    <!--<script src="<?= ASSETS_URL; ?>plugins/sweetalert2-11.4.0/sweetalert2.all.min.js"></script>--><!--- check usage link -->
    <!--// SweetAlert2 -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <!-- Production
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    -->

    <script src="<?= APP_URL; ?>vuejs/functions.js"></script>
    <script src="<?= APP_URL; ?>vuejs/vue.js"></script>
    <script src="<?= APP_URL; ?>vuejs/axios.js"></script>
    <script src="<?= APP_URL; ?>vuejs/auth.js"></script>