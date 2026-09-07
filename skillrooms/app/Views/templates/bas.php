

<?php
echo '
        </section>
        <!-- ESPACE ENTRE PAGE ET FOOTER -->
        <div style="height:400px;"></div>

        <!-- FOOTER -->
        <footer class="text-center text-white-50 py-4" 
                style="background:#0a0d12; border-top:1px solid #1f2a36;">
            <div class="container">

                <p class="mb-1" style="font-family:Orbitron, sans-serif; font-size:1.1rem; letter-spacing:3px; color:#00eaff;">
                    SkillRooms
                </p>

                <small class="text-white-50">
                    © '.date("Y").' – Plateforme d\'entraînement esport
                </small>

            </div>
        </footer>

        <!-- JS Bootstrap -->
         <!-- Core theme JS-->
        <script src="<?php echo base_url();?>bootstrap/js/scripts.js"></script>
        <!-- jQuery Version -->
        <script src="<?php echo base_url();?>bootstrap/js/jquery-1.11.0.js"></script>
        <!-- Boostrap JS -->
        <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- scripts du projet -->
        <script src="'.base_url().'bootstrap/js/scripts.js"></script>

    </body>
</html>
';
?>
