document.querySelectorAll(".add-to-cart").forEach(button => {
    button.addEventListener("click", () => {
        const product = {
            id: button.dataset.id,
            name: button.dataset.name,
            price: parseFloat(button.dataset.price),
            image: button.dataset.image,
            quantity: 1
        };

        let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

        const existing = cart.find(item => item.id === product.id);
        if (existing) {
            existing.quantity += 1;
            console.log(`✅ Increased quantity for: ${product.name}`);
        } else {
            cart.push(product);
            console.log(`🛒 Added new product: ${product.name}`);
        }

        sessionStorage.setItem("cart", JSON.stringify(cart));
        console.log("🧾 Current cart:", cart);

        // Show toast
        const toast = document.getElementById("cart-toast");
        toast.style.display = "block";
        setTimeout(() => {
            toast.style.display = "none";
        }, 1500);
    });
});
