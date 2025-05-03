<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PlaceHolder</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <?php
  include('includes/header.inc.php');
  ?>

  <!-- HERO COM CARROSSEL -->
  <section class="hero">
    <div class="carousel">

      <div class="carousel-item" id="heroSlide-1">
        <img src="public/assets/images/bard-fanart_1280x1266.jpg" alt="Slide 1" />
        <div class="hero-text">
          <h1>Lorem Ipsum</h1>
          <h1>Lorem Ipsum</h1>
          <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
        </div>
      </div>

      <div class="carousel-item" id="heroSlide-2">
        <img src="public/assets/images/gigante_1920x914.jpg" alt="Slide 2" />
        <div class="hero-text">
          <h1>Lorem Ipsum</h1>
          <h1>Lorem Ipsum</h1>
          <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
        </div>
      </div>

      <div class="carousel-item" id="heroSlide-3">
        <img src="public/assets/images/bard-fanart_1280x1266.jpg" alt="Slide 3" />
        <div class="hero-text">
          <h1>Lorem Ipsum</h1>
          <h1>Lorem Ipsum</h1>
          <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
        </div>
      </div>
    </div>

    <div class="carousel-indicators">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </section>
  <div class="homepage-main-container">
    <!-- EM DESTAQUE -->
    <section class="em-destaque">
      <h2 class="page-h1">Em Destaque</h2>
      <div class="destaque-grid">
        <div class="destaque-item">
          <img src="public/assets/images/<?= htmlspecialchars($artworks[0]['image']) ?>"
            alt="<?= htmlspecialchars($artwork['name']) ?>">
          <p>Lorem ipsum dolor</p>
        </div>
        <div class="destaque-item">
          <img src="imagem-destaque2.jpg" alt="Destaque 2">
          <p>Lorem ipsum dolor</p>
        </div>
        <div class="destaque-item">
          <img src="imagem-destaque3.jpg" alt="Destaque 3">
          <p>Lorem ipsum dolor</p>
        </div>
      </div>
    </section>

    <!-- TRABALHOS RECENTES -->
    <section class="trabalhos-recentes">
      <h2 class="page-h1">Trabalhos Recentes</h2>
      <div class="recentes-grid">

        <?php foreach ($artworks as $artwork): ?>
          <a href="/tcc/product?id=<?= htmlspecialchars($artwork['id']) ?>" id="<?= htmlspecialchars($artwork['id']) ?>">
            <div class="recente-item">
              <div>
                <img src="public/assets/images/<?= htmlspecialchars($artwork['image']) ?>"
                  alt="<?= htmlspecialchars($artwork['name']) ?>">
              </div>
              <p>Lorem ipsum dolor</p>
            </div>
          </a>
        <?php endforeach; ?>

      </div>
    </section>
  </div>
  <!-- FOOTER -->
  <footer>
    <div class="footer-content">
      <div class="contact">
        <p>+351 999 999 999</p>
      </div>
      <div class="policies">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Use</a>
        <a href="#">Cookies Policy</a>
      </div>
      <div class="newsletter">
        <h3>Se inscreva na newsletter</h3>
        <form>
          <input type="email" placeholder="Seu email" required />
          <button type="submit">Inscrever</button>
        </form>
      </div>
    </div>
  </footer>

  <script>
    const carousel = document.querySelector('.carousel');
    const slides = document.querySelectorAll('.carousel-item');
    const dots = document.querySelectorAll('.dot');

    let currentIndex = 0;
    const totalSlides = slides.length;

    updateCarousel();
    console.log(dots);

    let autoPlay = setInterval(nextSlide, 15000);

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateCarousel();
    }

    function goToSlide(index) {
      currentIndex = index;
      updateCarousel();
    }

    function updateCarousel() {
      carousel.style.transform = `translateX(-${currentIndex * 100}%)`;

      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentIndex);
      });
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        clearInterval(autoPlay);
        goToSlide(i);
      });
    });
  </script>
</body>

</html>