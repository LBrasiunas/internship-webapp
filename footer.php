<?php
    function callAlert($text, $alertType){
        echo "
                       <div class='container mt-5'>
                            <div class='row justify-content-center'>
                                <div class='col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8'>
                                    <div class='alert text-center $alertType' role='alert'>
                                        $text
                                    </div>
                                </div>
                            </div>    
                       </div>
                        
                     ";
    }

    echo "
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (() => {
                'use strict'
    
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                const forms = document.querySelectorAll('.needs-validation')
    
                // Loop over them and prevent submission
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
    
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>
        ";
    //echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js' integrity='sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2' crossorigin='anonymous'></script>";

