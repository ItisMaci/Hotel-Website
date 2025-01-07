        <!--- Footer --->
        <footer class="bg-dark text-light py-5">
        <div class="container ">
            <div class="row">
                <div class="col">
                    <p class="fw-bold fs-4">XENIA <i class="bi bi-lightning-charge-fill" style="color: #6C63FF"></i></p>
                </div>
                <div class="col">
                    <p class="fw-bold fs-5">Menu</p>
                    <ul class="list-unstyled">
                        <li><a href="/Hotel-Website/index.php?page=rooms" class="text-decoration-none text-light">Rooms</a></li>
                        <li><a href="/Hotel-Website/index.php?page=news" class="text-decoration-none text-light">News</a></li>
                        <?php if(isset($_SESSION["loggedin"])) {?>
                            <li><a href="/Hotel-Website/index.php?page=profile" class="text-decoration-none text-light">My Profile</a></li> 
                        <?php }?>
                        <li><a href="/Hotel-Website/index.php?page=impressum" class="text-decoration-none text-light">Impressum</a></li>
                        <li><a href="/Hotel-Website/index.php?page=faq" class="text-decoration-none text-light">FAQ</a></li>
                    </ul>
                </div>
                <div class="col">
                    <p class="fw-bold fs-5">Contact</p>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-light">+43 515 555 677</a></li>
                        <li><a href="#" class="text-decoration-none text-light">xenia@mail.com</a></li>
                    </ul>
                </div>
            
                <div class="col">
                    <p class="fw-bold fs-5">Social Media</p> 
                    <ul class="list-unstyled d-flex">
                        <li><a href="#" class="text-decoration-none text-light"><i class="bi bi-instagram fs-5 me-3"></i></a></li>
                        <li><a href="#" class="text-decoration-none text-light"><i class="bi bi-twitter fs-5 me-3"></i></a></li>
                        <li><a href="#" class="text-decoration-none text-light"><i class="bi bi-envelope-fill fs-5 me-3"></i></a></li>
                        <li><a href="#" class="text-decoration-none text-light"><i class="bi bi-linkedin fs-5 me-3"></i></a></li>
                    </ul>
                </div>
                <hr>
                   <p class="text-center">© 2024 Ensar Mehmedovic, Marcel Scheder, XENIA. All rights reserved. Vienna</p>
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
