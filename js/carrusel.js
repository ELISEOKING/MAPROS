    const carousel = document.getElementById("carousel");
    const cards = carousel.querySelectorAll(".card");
    const popupBg = document.getElementById("popup-bg");
    let currentIndex = 0;
    let isPopupOpen = false;

    let isDragging = false,
      dragStartX = 0,
      dragDeltaX = 0;

    let rotationAngle = 0;

    function getSettings() {
      const w = window.innerWidth;
      if (w <= 400) return { step: 45, radius: 160 };
      if (w <= 600) return { step: 50, radius: 200 };
      if (w <= 768) return { step: 60, radius: 260 };
      return { step: 72, radius: 350 };
    }

    function positionCards() {
      const { step, radius } = getSettings();
      cards.forEach((c, i) => {
        const rot = i * step;
        const rad = rot * Math.PI / 180;
        const x = Math.sin(rad) * radius;
        const z = Math.cos(rad) * radius;
        c.dataset.baseTransform = `translateX(${x}px) translateZ(${z}px) rotateY(${rot}deg)`;
      });
      scaleCurrent();
    }

    function scaleCurrent() {
      cards.forEach((c, i) => {
        if (i === currentIndex) {
          c.style.transform = c.dataset.baseTransform + " scale(1.15)";
          c.style.zIndex = "10";
          c.style.filter = "drop-shadow(0 5px 10px rgba(0,0,0,0.2))";
        } else {
          c.style.transform = c.dataset.baseTransform + " scale(0.85)";
          c.style.zIndex = "1";
          c.style.filter = "none";
        }
      });
    }

    function rotateToIndex(index) {
      const { step } = getSettings();
      rotationAngle = -index * step;
      carousel.style.transform = `rotateY(${rotationAngle}deg)`;
      currentIndex = index;
      scaleCurrent();
    }

    function animate() {
      // No auto rotate for smoother UX (optional)
      requestAnimationFrame(animate);
    }

    // Drag / Mouse controls
    carousel.addEventListener("mousedown", e => {
      if (isPopupOpen) return;
      isDragging = true;
      dragStartX = e.clientX;
      dragDeltaX = 0;
      carousel.style.cursor = "grabbing";
    });

    window.addEventListener("mousemove", e => {
      if (!isDragging) return;
      dragDeltaX = e.clientX - dragStartX;
      const { step } = getSettings();
      const temp = -currentIndex * step + dragDeltaX / 5;
      carousel.style.transform = `rotateY(${temp}deg)`;
    });

    window.addEventListener("mouseup", e => {
      if (!isDragging) return;
      carousel.style.cursor = "grab";
      isDragging = false;
      if (dragDeltaX > 30) rotateToIndex((currentIndex - 1 + cards.length) % cards.length);
      else if (dragDeltaX < -30) rotateToIndex((currentIndex + 1) % cards.length);
      else rotateToIndex(currentIndex);
    });

    // Touch controls
    carousel.addEventListener("touchstart", e => {
      if (isPopupOpen) return;
      isDragging = true;
      dragStartX = e.touches[0].clientX;
      dragDeltaX = 0;
    });

    carousel.addEventListener("touchmove", e => {
      if (!isDragging) return;
      dragDeltaX = e.touches[0].clientX - dragStartX;
      const { step } = getSettings();
      const temp = -currentIndex * step + dragDeltaX / 5;
      carousel.style.transform = `rotateY(${temp}deg)`;
    });

    carousel.addEventListener("touchend", e => {
      if (!isDragging) return;
      isDragging = false;
      if (dragDeltaX > 30) rotateToIndex((currentIndex - 1 + cards.length) % cards.length);
      else if (dragDeltaX < -30) rotateToIndex((currentIndex + 1) % cards.length);
      else rotateToIndex(currentIndex);
    });

    // Scroll wheel control
    let wheelTimeout;
    carousel.addEventListener("wheel", e => {
      if (isPopupOpen) return;
      e.preventDefault();

      if (e.deltaY > 0) rotateToIndex((currentIndex + 1) % cards.length);
      else if (e.deltaY < 0) rotateToIndex((currentIndex - 1 + cards.length) % cards.length);

      clearTimeout(wheelTimeout);
      wheelTimeout = setTimeout(() => { }, 150); // debounce if needed
    }, { passive: false });

    // Popup logic
    function showPopup(id) {
      const popup = document.getElementById(`popup-${id}`);
      if (popup) {
        popup.classList.add("show");
        popupBg.classList.add("show");
        isPopupOpen = true;
      }
    }

    function closePopup() {
      document.querySelectorAll(".popup.show").forEach(p => p.classList.remove("show"));
      popupBg.classList.remove("show");
      isPopupOpen = false;
    }

    cards.forEach(c => {
      c.addEventListener("click", () => {
        showPopup(c.dataset.id);
      });
      c.addEventListener("keydown", e => {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          showPopup(c.dataset.id);
        }
      });
    });

    popupBg.addEventListener("click", closePopup);
    window.addEventListener("keydown", e => {
      if (e.key === "Escape" && isPopupOpen) {
        closePopup();
      }
    });

    // Inicializa posiciones
    positionCards();
    rotateToIndex(0);

    // Recalcula en resize
    window.addEventListener("resize", () => {
      positionCards();
      rotateToIndex(currentIndex);
    });
    let autoRotate = true;         // Controla si gira automáticamente
    let autoRotateSpeed = 0.1;     // Grados por frame (ajusta para más lento o rápido)

    function animate() {
      if (autoRotate && !isDragging && !isPopupOpen) {
        rotationAngle -= autoRotateSpeed;
        carousel.style.transform = `rotateY(${rotationAngle}deg)`;
        // Ajustar currentIndex para escala y efectos:
        const { step } = getSettings();
        // Normalizar ángulo para encontrar índice más cercano
        let normalizedAngle = ((-rotationAngle % 360) + 360) % 360;
        let index = Math.round(normalizedAngle / step) % cards.length;
        currentIndex = index;
        scaleCurrent();
      }
      requestAnimationFrame(animate);
    }

    animate();

    // Modifica eventos drag para pausar autoRotate:

    carousel.addEventListener("mousedown", e => {
      if (isPopupOpen) return;
      isDragging = true;
      dragStartX = e.clientX;
      dragDeltaX = 0;
      autoRotate = false;          // Pausa rotación al arrastrar
      carousel.style.cursor = "grabbing";
    });

    window.addEventListener("mouseup", e => {
      if (!isDragging) return;
      carousel.style.cursor = "grab";
      isDragging = false;
      if (dragDeltaX > 30) rotateToIndex((currentIndex - 1 + cards.length) % cards.length);
      else if (dragDeltaX < -30) rotateToIndex((currentIndex + 1) % cards.length);
      else rotateToIndex(currentIndex);
      autoRotate = true;           // Reanuda rotación al soltar
    });

    // Igual para touchstart y touchend

    carousel.addEventListener("touchstart", e => {
      if (isPopupOpen) return;
      isDragging = true;
      dragStartX = e.touches[0].clientX;
      dragDeltaX = 0;
      autoRotate = false;
    });

    carousel.addEventListener("touchend", e => {
      if (!isDragging) return;
      isDragging = false;
      if (dragDeltaX > 30) rotateToIndex((currentIndex - 1 + cards.length) % cards.length);
      else if (dragDeltaX < -30) rotateToIndex((currentIndex + 1) % cards.length);
      else rotateToIndex(currentIndex);
      autoRotate = true;
    });

    // Pausar autoRotate cuando el popup está abierto y reanudar al cerrar:

    function showPopup(id) {
      const popup = document.getElementById(`popup-${id}`);
      if (popup) {
        popup.classList.add("show");
        popupBg.classList.add("show");
        isPopupOpen = true;
        autoRotate = false;
      }
    }

    function closePopup() {
      document.querySelectorAll(".popup.show").forEach(p => p.classList.remove("show"));
      popupBg.classList.remove("show");
      isPopupOpen = false;
      autoRotate = true;
    }
