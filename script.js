document.querySelectorAll(".users-table--delete").forEach(boton => {
    boton.addEventListener("click", function(event) {
        event.preventDefault(); // Evita que el enlace se ejecute inmediatamente
        const confirmacion = confirm("¿Seguro que quieres eliminar este usuario?");
        if (confirmacion) {
            window.location.href = this.href; // Redirige solo si el usuario confirma
        }
    });
});
