//this is for the dynamic load of the items in the shop

function dynLoadContentOnScroll(){
    var content = document.getElementById('products');
    var contentOffset = getOffset(content);
    var contentHeight = content.offsetHeight;
    var y = window.pageYOffset + window.innerHeight;
	if(y >= contentOffset + contentHeight - 200){
        var parameters = getUrlVars();
        var productCount = content.getElementsByClassName('product').length;
        parameters['productCount'] = productCount;
        parameters['ajax'] = 1;
        var url = window.location.pathname + urlParametersToString(parameters);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                var products = response['products'];
                var content = document.getElementById('products');
                var productCount = content.getElementsByClassName('product').length;
                if(productCount == response['productCount'])
                {
                    for(idx in products)
                    {
                        article = buildHTMLForProduct(products[idx]);
                        content.appendChild(article);
                    }
                }
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
	}
}