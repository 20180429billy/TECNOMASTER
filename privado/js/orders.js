const themeToggler = document.querySelector(".theme-toggler");


themeToggler.addEventListener("click", ()=>{
    document.body.classList.toggle('dark-theme-variables'); 
    themeToggler.querySelector("span:nth-child(1)").classList.toggle("active");
    themeToggler.querySelector("span:nth-child(2)").classList.toggle("active");
});

const Orders = [
    {
        productName : "Foldable mini drone",
        productNumber : "85631",
        paymentStatus : "Due",
        shipping : "Pending"
    },
    {
        productName : "Foldable mini drone",
        productNumber : "85631",
        paymentStatus : "Due",
        shipping : "Pending"
    },
    {
        productName : "Foldable mini drone",
        productNumber : "85631",
        paymentStatus : "Due",
        shipping : "Pending"
    },
    {
        productName : "Foldable mini drone",
        productNumber : "85631",
        paymentStatus : "Due",
        shipping : "Pending"
    },
    {
        productName : "Foldable mini drone",
        productNumber : "85631",
        paymentStatus : "Due",
        shipping : "Pending"
    }    
]

Orders.forEach( order => {
    const tr = document.createElement("tr");
    const trContent = `
        <td>${order.productName}</td>
        <td>${order.productNumber}</td>
        <td>${order.paymentStatus}</td>
        <td class="${order.shipping === 'Declined' ? 'danger' : order.shipping === 'pending' ? 'warning' : 'primary'}">${order.shipping}</td>
        <td class="primary">Details</td>
    `;
    tr.innerHTML = trContent;
    document.querySelector("table tbody").appendChild(tr);

    
})