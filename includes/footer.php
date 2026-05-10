<style>
    .fs-footer {
    background-color: #0a0a0a;
    color: #ffffff;
    padding: 0;
    }

    .footer-description {
        font-size: 0.85rem;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 0;
    }

    .footer-link {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.3s ease;
    }

    .footer-link:hover {
        color: var(--fs-green);
    }

    .fs-footer h5 {
        font-size: 0.9rem;
        letter-spacing: 1px;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .copyright-text {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.4);
        margin: 0;
    }

    .fs-footer hr {
        margin: 0;
        border-color: rgba(255, 255, 255, 0.1);
    }
</style>

<footer class="fs-footer">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-5 mb-4 mb-md-0">
                <div class="mb-3">
                    <img src="/DSS404-TEORICO/resources/img/logofooter.png" alt="Foodshare" style="height: 45px; width: auto;" onerror="this.style.display='none'; this.nextSibling.style.display='inline-block'">
                    <span class="text-success fw-bold" style="font-size: 1.5rem; display: none;">foodshare</span>
                </div>
                <p class="footer-description">
                    Conectando excedentes de alimentos con quienes más lo necesitan en El Salvador. Una iniciativa para reducir el desperdicio y combatir el hambre.
                </p>
            </div>

            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-white mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="views/restaurante/registro.php" class="footer-link">Registrar Restaurante</a></li>
                    <li class="mb-2"><a href="views/ong/registro.php" class="footer-link">Registrar ONG</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Preguntas Frecuentes</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Términos y Condiciones</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h5 class="text-white mb-3">Contacto</h5>
                <p class="mb-2">
                    <i class="fa-regular fa-envelope text-success me-2"></i>
                    <span class="text-success">contacto@foodshare.sv</span>
                </p>
                <p class="mb-0">
                    <i class="fa-solid fa-phone text-success me-2"></i>
                    <span class="text-success">+503 2200-0000</span>
                </p>
            </div>
        </div>

        <!-- Línea divisoria -->
        <hr class="border-secondary opacity-25 my-3">

        <!-- Copyright -->
        <div class="row pb-3">
            <div class="col-12 text-center">
                <p class="copyright-text mb-0">
                    &copy; <?php echo date("Y"); ?> Foodshare - Proyecto de Cátedra. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>