
        <?php
            $user = auth::user();
            $first_name = $user->first_name;
            $last_name = $user->last_name;
        ?>
        <html dir="rtl">
            <body dir="rtl">

            <main class="container">
                <div class="container content text-right">
                    <br>
                    <div class="container">
                        <div class="row justify-content-center position-relative" style="bottom:30px">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header text-center"><b>הטענה נכשלה</b></div>
                                    <div class="card-body container">
                                        <br>
                                        יש תקלה עם כרטיס האשראי שלך. אנא נסה שנית
                                    </div>
                                </div>
                                <button id="form-button" onclick="window.top.location.href = '{{env("APP_URL")}}'"> אישור ומעבר לתפריט הראשי </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>
            </main>
            </body>
        </html>
        <script>
            alert("לידיעתך, כרטיסך אינו חויב");
        </script>
