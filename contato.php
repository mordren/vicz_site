<?php include 'includes/header.php'; ?>
<main class="container my-5">

    <!-- Seção de Contato -->
    <section id="contato" class="card p-4 shadow-lg border-0">
        <h2 class="text-center mb-4 text-primary">📞 Entre em Contato</h2>

        <div class="row text-center">
            <!-- Localização -->
            <div class="col-md-6 mb-4">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-map-marker-alt fa-2x text-danger me-3"></i>
                    <div>
                        <strong> Localização:</strong>  
                        <p class="mb-0">Distrito de Luzimangues, TO-080</p>
                    </div>
                </div>
            </div>

            <!-- Telefone -->
            <div class="col-md-6 mb-4">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-phone-alt fa-2x text-primary me-3"></i>
                    <div>
                        <strong> Telefone:</strong>  
                        <p class="mb-0">
                            <a href="tel:+556341413535" class="text-dark text-decoration-none">
                                (63) 4141-3535
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-4">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-envelope fa-2x text-warning me-3"></i>
                    <div>
                        <strong> Email:</strong>  
                        <p class="mb-0">
                            <a href="mailto:viczimplementos@gmail.com" class="text-dark text-decoration-none">
                                viczimplementos@gmail.com
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- WhatsApp -->
            <div class="col-md-6 mb-4">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-whatsapp fa-2x text-success me-3"></i>
                    <div>
                        <strong> WhatsApp:</strong>  
                        <p class="mb-0">
                            <a href="https://wa.me/556341413535" target="_blank" class="btn btn-success btn-sm">
                                <i class="fa fa-whatsapp"></i> Fale Conosco
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção do Google Maps -->
    <section class="my-5">
        <h2 class="text-center text-primary">📍 Nossa Localização</h2>
        <p class="text-center">Estamos localizados em Luzimangues, Porto Nacional - TO, ao lado de Palmas.</p>
        
        <div class="map-responsive text-center">
            <iframe
                width="100%"
                height="400"
                frameborder="0"
                style="border:0; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.853202123026!2d-48.3287!3d-10.2703!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x933b3d6f717cd8ff%3A0x1234567890abcdef!2sLuzimangues%2C%20Porto%20Nacional%20-%20TO!5e0!3m2!1spt-BR!2sbr!4v1234567890">
            </iframe>
        </div>
    </section>

</main>
<?php include 'includes/footer.php'; ?>
