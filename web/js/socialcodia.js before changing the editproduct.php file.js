    
function dd(value)
{
  console.log(value);
}


function showLoadingAnimation()
{
  let divProcess = document.getElementById('divProcess');
  let loadingAnimationDiv = `<div class="center"><img src="src/gif/11.gif" class="responsive-img center" width="500"></div>`;
  divProcess.innerHTML = loadingAnimationDiv;
}

function getError(errorMessage)
{
  let html = `<div class="center"><h4>${errorMessage}</h4><img class="verticalCenter socialcodia" src="src/img/empty_cart.svg"</div>`;
  return html;
}

function hideLoadingAnimation()
{
  let divProcess = document.getElementById('divProcess');
  divProcess.innerHTML = '';
}

let pathname = document.location.pathname;
let endPathname = pathname.substring(pathname.lastIndexOf('/') + 1);

function closeModal(){
  $('#modal1').modal('close');
}


function openSellOnCreditModal(){
  $('#modalSellOnCredit').modal('open');
}

function closeSellOnCreditModal(){
  $('#modalSellOnCredit').modal('close');
}

function openAddItemModal(){
  $('#modalAddItem').modal('open');
}

function closeAddItemModal(){
  $('#modalAddItem').modal('close');
}

function openModal(){
  $('#modal1').modal('open');
  document.getElementById('productName').focus();
}
let token = getToken();
$(document).ready(function ()
{
//   $('#tableBody').find('tr').click( function(){
//   if($(this).attr('class')=== undefined)
//     $(this).addClass('rowColor');
//   else
//     $(this).removeAttr('class');
// });
  firdos();
  $('.modal').modal();
  $('.tooltipped').tooltip();
  $('.collapsible').collapsible();
  $('.sidenav').sidenav();
  $('.snavright').sidenav({
    menuWidth: 300,
    closeOnClick: true,
      edge: 'right', // <--- CHECK THIS OUT
    }
    );
    // $('select').select2({width: "100%"});
    $('select').select2({width: "100%"});
    changePageName();
    if (endPathname=='addproduct' || endPathname=='editproduct') 
    {
      getBrands();
      getSizes();
      getCategories();
      getLocations();
      getItems();
    }
    else if (endPathname == 'selltoseller')
    {
      getSellers();
    }
    else if(endPathname=='dashboard')
    {
      getSalesStatusByMonth();
      getSellerSalesStatusByMonth();
      getSalesStatusByDays();
      chartTopProductsRecord();
      chartTopProductsRecordYearly();
      setTopTenSellersMonthly();
      setTopTenSellersYearly();
    }
    else if (endPathname == 'seller')
    {
      setSellerIncome();
    }
    else if(endPathname== 'salesall')
    {
      let date = new Date();
      let day = date.getDate();
      let month = date.getMonth() + 1;
      let year = date.getFullYear();
      if (month < 10) month = "0" + month;
      if (day < 10) day = "0" + day;
      let today = year + "-" + month + "-" + day;
      document.getElementById('toDate').value = today;
      document.getElementById('fromDate').value = today;
      fetchProductRecordByDate();
    }
    else if(endPathname == 'products')
    {
      getAllProduct();
    }
    else if(endPathname == 'productsnotice')
    {
      getNoticeProducts();
    }
    else if(endPathname == 'expiringproducts')
    {
      getExpiringProducts();
    }
    else if(endPathname == 'expiredproducts')
    {
      getExpiredProducts();
    }
    else if(endPathname== 'salestoday')
    {
      getTodaysSalesRecord();
    }
    else if(endPathname == 'invoices')
    {
      getInvoices();
    }
    else if(endPathname == 'sellers')
    {
      getAllSellers();
    }
    else if(endPathname == 'productsrecord')
    {
      getProductsRecord();
    }
    else if(endPathname=='sell')
    {
      // getAvailableProducts();
    }
    else if(endPathname == 'credits')
    {
      getCredits();
    }
  });

function previewSellerImage(input) 
{
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#sellerImage')
      .attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function previewAdminImage(input) 
{
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#adminImagePreview')
      .attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}



function setSelectedValue(name)
{
  let selectBrand = document.getElementById('selectBrand');
  // $('select').select2({width: "100%"});
  $('select').select2({width: "100%"});
}

function playSuccess()
{
  let audio = new Audio('src/aud/success.ogg');
  audio.play();
}

function playError()
{
  let audio = new Audio('src/aud/error.ogg');
  audio.play();
}


function playWarning()
{
  let audio = new Audio('src/aud/warning.ogg');
  audio.play();
}

function fetchItemAgain()
{
  if (endPathname==='addproduct')
  {
    getItems();
  }
}

function getToken() {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; token=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

function setPageName(name)
{
  let pageName = document.getElementById('pageName');
  pageName.innerHTML = name;
  document.title = name;
}

function setButtonAtPageName()
{
  let pageName = document.getElementById('pageName');
  let button = '<Button class="btn blue" onclick="sellOnCredit()" id="sellOnCredit">Add Credit record</Button>'
  pageName.innerHTML = button;
  document.title = 'Sell Product';
}

function setAddItemButtonAtPageName()
{
  let pageName = document.getElementById('pageName');
  let button = '<Button class="btn blue" onclick="openAddItemModal()" id="btnOpenItemModal">Add an Item</Button>'
  pageName.innerHTML = button;
  document.title = 'Add Product';
}

function creditPaidAmountChangeEvent()
{
  let paidAmount = document.getElementById('paidAmount');
  let totalPrice = document.getElementById('htmlCreditDiscountPrice');
  let remainingAmount = document.getElementById('htmlCreditRemainingAmount');

  let amount = parseInt(paidAmount.value);
  let price = parseInt(totalPrice.innerHTML);
  let w = price-amount;
  if (w<0)
  {
    paidAmount.value = price;
    remainingAmount.innerHTML = 0;
    makeToast('error',"Amount Is Greater Than Credit Amount");
  }
  else
    remainingAmount.innerHTML = price-amount;
}

function makeToast(icon,message)
{
  Toast.fire({
    icon: icon,
    title: message
  });
  switch(icon)
  {
    case 'error':
    playError();
    break;
    case 'warning':
    playWarning();
    break;
    case 'success':
    playSuccess();
    break;
  }
}
let arraySalesId = new Array();

function sellOnCredit()
{
  arraySalesId = [];
  let table = document.getElementById('mstrTable');
  let count = 1;
  let SellRecordTableBody = document.getElementById('SellRecordTableBody');
  let SellOnCreditTableBody = document.getElementById('SellOnCreditTableBody');
  let htmlTotalPrice = document.getElementById('htmlTotalPrice');
  let htmlDiscountPrice = document.getElementById('htmlDiscountPrice');
  let htmlCreditDiscountPrice = document.getElementById('htmlCreditDiscountPrice');
  let htmlCreditTotalPrice = document.getElementById('htmlCreditTotalPrice');
  let childrenLength = SellRecordTableBody.children.length;
  if (childrenLength>0)
    openSellOnCreditModal();
  else
    makeToast('error','Sale Record Is Empty')
  SellOnCreditTableBody.innerHTML = '';
  for(let i=0; i<childrenLength; i++)
  {
    let items = SellRecordTableBody.rows[i];
    let tr = document.createElement('tr');
    let saleId = items.cells[1].firstElementChild.value;
    arraySalesId[i] = saleId;
    let productName = items.cells[2].innerHTML;
    let productSize = items.cells[3].innerHTML;
    let productPrice = items.cells[4].innerHTML;
    let productQuantity = items.cells[5].firstElementChild.value;
    let productSellPrice = items.cells[9].firstElementChild.value;
    let productBrand = items.cells[10].innerHTML;
    let tdSaleId = '<td>'+count+'</td>'
    let tdProductName = '<td>'+productName+'</td>'
    let tdProductSize = '<td>'+productSize+'</td>'
    let tdProductPrice = '<td>'+productPrice+'</td>'
    let tdProductQuantity = '<td>'+productQuantity+'</td>'
    let tdProductSellPrice = '<td>'+productSellPrice+'</td>'
    let tdProductBrand = '<td>'+productBrand+'</td>'
    tr.innerHTML = tdSaleId+tdProductName+tdProductSize+tdProductPrice+tdProductQuantity+tdProductSellPrice+tdProductBrand;
    SellOnCreditTableBody.append(tr);
    count++;
  }
  htmlCreditDiscountPrice.innerHTML = htmlDiscountPrice.innerHTML;
  creditPaidAmountChangeEvent();
}

function alertSellOnCredit()
{
  let paidAmount = document.getElementById('paidAmount');
  let creditorName = document.getElementById('creditorName');
  let creditDate = document.getElementById('creditDate');
  let crName = document.getElementById('customerName');
  let crMobile = document.getElementById('customerMobile');
  let crAddress = document.getElementById('customerAddress');
  let name = crName.value;
  let mobile = crMobile.value;
  let address = crAddress.value;
  let amount = paidAmount.value;
  if (name=='' || name.length<3)
  {
    makeToast('error','Enter Name');
    return;
  }
  if (mobile.length=='') 
  {
    makeToast('error','Enter Mobile Number');
    return;
  }
  if (address.length<3)
  {
    makeToast('error','Enter Address');
    return;
  }
  if (mobile.length!=10) 
  {
    makeToast('error','Enter Valid Mobile Number');
    return;
  }
  let text = "<b>You are going to add a credit record for <span class='blue-text'>"+name+"</span> which is paying you <h4 style='font-weight:bold; color:red'>"+amount+' Rupees'+"</h4> For this credit record</b>";
  Swal.fire({
    icon: 'warning',
    title: 'Are you sure?',
    showCancelButton: true,
    confirmButtonText: `Accept Payment`,
    denyButtonText: `Cancel Payment`,
    html: text
  }).then((result) => {
    if (result.isConfirmed) 
    {
      sellOnCreditDB();
    }
  });
}

function sellOnCreditDB()
{
  let crName = document.getElementById('customerName');
  let crMobile = document.getElementById('customerMobile');
  let crAddress = document.getElementById('customerAddress');
  let paidAmount = document.getElementById('paidAmount');
  let crDesc = document.getElementById('customerDescription');
  let btnSellOnCredit = document.getElementById('btnSellOnCredit');

  let name = crName.value;
  let mobile = crMobile.value;
  let address = crAddress.value;
  let amount = paidAmount.value;
  let desc = crDesc.value;
  arraySalesId = JSON.stringifyIfObject(arraySalesId);

  btnSellOnCredit.classList.add('disabled');
  $.ajax({
    headers:{  
     'token':token
   },
   type:"post",
   url:BASE_URL+"product/sell/credit",
   data: 
   {  
     'creditorName' : name,
     'creditorMobile' : mobile,
     'creditorAddress' : address,
     'paidAmount' : amount,
     'creditDescription' : desc,
     'salesId' : arraySalesId
   },
   success:function(response)
   {
    let desc = 'You have added '+amount+' Rupees';
    
    if (!response.error)
    {
      closeSellOnCreditModal();
      playSuccess();
      Swal.fire(
        'Credit Added',
        desc,
        'success'
        )
      btnSellOnCredit.classList.add('disabled');
    }
    else
    {
      makeToast('error',response.message);
      btnSellOnCredit.classList.remove('disabled');
    }
  }
});
  btnSellOnCredit.classList.remove('disabled');

}

JSON.stringifyIfObject = function stringifyIfObject(obj){
  if(typeof obj == "object")
    return JSON.stringify(obj);
  else{
    return obj;
  }
}


function changePageName()
{
  let location = window.location.pathname;
  let pathname = location.substring(location.lastIndexOf('/') + 1);

  switch(pathname)
  {
    case 'dashboard':
    setPageName('Dashboard');
    break;
    case 'sell':
          // setPageName('Sell Product');
          setButtonAtPageName();
          break;
          case 'products':
          setPageName('All Products');
          break;
          case 'addproduct':
          setAddItemButtonAtPageName();
          break;
          case 'expiringproducts':
          setPageName('Expiring Products');
          break;
          case 'productsnotice':
          setPageName('Products Notice');
          break;
          case 'expiredproducts':
          setPageName('Expired Products');
          break;
          case 'productsrecord':
          setPageName('Products Record');
          break;
          case 'addproductsinfo':
          setPageName('Add Products Information');
          break;
          case 'editproduct':
          setPageName('Edit Product');
          break;
          case 'salestoday':
          setPageName('Todays Sale');
          break;
          case 'salesall':
          setPageName('All Sales');
          break;
          case 'addseller':
          setPageName('Add Seller');
          break;
          case 'sellers':
          setPageName('All Sellers');
          break;
          case 'selltoseller':
          setPageName('Sell To Seller');
          break;
          case 'invoices':
          setPageName('Invoices');
          break;
          case 'invoice':
          setPageName('Invoice');
          break;
          case 'payment':
          setPageName('Payment');
          break;
          case 'sellers':
          setPageName('All Sellers');
          break;
          case 'credits':
          setPageName('Credits');
          break;
          case 'creditors':
          setPageName('Creditors');
          break;
          case 'admins':
          setPageName('Admins');
          break;
          case 'addadmin':
          setPageName('Add Admin');
          break;
          case 'settings':
          setPageName('Settings');
          break;
          default:
          setPageName('Social Codia');
          break;

        }
      }

      function openModalTextController()
      {
        let inputOpenModal = document.getElementById('inputOpenModal');
        let inputModal = document.getElementById('productName');
        inputModal.value = inputOpenModal.value;
        inputModal.focus();
        inputOpenModal.value = null;
        openModal();
        filterProduct();
      }

      function getSalesStatusByMonth()
      {
        let ctx = document.getElementById('chatSalesRecordOfMonths').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"sales/status/months",
         success:function(response)
         {
          
          if(!response.error)
          {
            let status = response.status;
            let labels = status.map((e)=>{
              return e.month;
            });

            let data = status.map((e)=>
            {
              return e.totalSales;
            });
            let chatSalesRecordOfMonths = new Chart(ctx, {
              type: 'line',
              data: {
                labels: labels,
                datasets: [{
                  label: ['Monthly Sales'],
                  data: data,
                  backgroundColor: '#3e95cd'
                }]
              }
            });
          }
          else
          {
            makeToast('error',response.message);
          }
        }
      });
      }

      function getSellerSalesStatusByMonth()
      {
        let ctx = document.getElementById('chatSellerSalesRecordOfMonths').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"seller/sales/status/months",
         success:function(response)
         {
          
          if(!response.error)
          {
            let status = response.status;
            let labels = status.map((e)=>{
              return e.month;
            });

            let data = status.map((e)=>
            {
              return e.totalSales;
            });
            let chatSellerSalesRecordOfMonths = new Chart(ctx, {
              type: 'line',
              data: {
                labels: labels,
                datasets: [{
                  label: ['Monthly Sales To Seller'],
                  data: data,
                  backgroundColor: "#3e95cd",
                  borderColor: ['black','black','black','black','black','black',]
                }]
              }
            });
          }
          else
          {
            makeToast('error',response.message);
          }
        }
      });
      }

      function chartTopProductsRecord()
      {
        let ctx = document.getElementById('chartTopProductsRecord').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"sales/status/products",
         success:function(response)
         {
          
          if(!response.error)
          {
            let products = response.products;
            let labels = products.map((e)=>{
              return e.productName;
            });

            let data = products.map((e)=>
            {
              return e.saleQuantity;
            });
            let chartTopProductsRecord = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: ['TOP 10 Selling Products Of This Month'],
                  data: data,
                  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                  borderColor: ['black','black','black','black','black','black',]
                }]
              }
            });
          }
          else
            makeToast('error',response.message);
        }
      });
      }

      function setTopTenSellersMonthly()
      {
        let ctx = document.getElementById('chartTopTenSellersMonthly').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"sellers/top/monthly",
         success:function(response)
         {
          if(!response.error)
          {
            let sellers = response.sellers;
            let labels = sellers.map((e)=>{
              return e.sellerName;
            });

            let data = sellers.map((e)=>
            {
              return e.sales;
            });

            let chartTopTenSellersMonthly = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: ['Top Ten Sellers Of This Month'],
                  data: data,
                  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                  borderColor: ['black','black','black','black','black','black',]
                }]
              }
            });
          }
          else
            makeToast('error',response.message);
        }
      });
      }

      function setTopTenSellersYearly()
      {
        let ctx = document.getElementById('chartTopTenSellersYearly').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"sellers/top/yearly",
         success:function(response)
         {
          if(!response.error)
          {
            let sellers = response.sellers;
            let labels = sellers.map((e)=>{
              return e.sellerName;
            });

            let data = sellers.map((e)=>
            {
              return e.sales;
            });
            let chartTopTenSellersYearly = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: ['Top Ten Sellers Of This Year'],
                  data: data,
                  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                  borderColor: ['black','black','black','black','black','black',]
                }]
              }
            });
          }
          else
            makeToast('error',response.message);
        }
      });
      }

      function fetchProductRecordByDate()
      {
        showLoadingAnimation();
        let elemFromDate = document.getElementById('fromDate');
        let elemToDate = document.getElementById('toDate');
        let tableBody = document.getElementById('tableBody');
        let totalPrice = document.getElementById('totalPrice');
        let sellPrice = document.getElementById('sellPrice');
        let btnFetchProduct = document.getElementById('btnFetchProduct');
        let fromDate = elemFromDate.value;
        let toDate = elemToDate.value;
        let trList = '';
        let count = 0;
        let tPrice = 0;
        let sPrice = 0;
        let finalTPrice = 0;
        let finalSPrice = 0;
        if(fromDate=="")
        {
          makeToast('error','Select From Date');
          return;
        }
        if(toDate=="")
        {
          makeToast('error','Select To Date');
          return;
        }
        tableBody.innerHTML = '';
        btnFetchProduct.classList.add('disabled');
        elemFromDate.setAttribute('disabled','disabled');
        elemToDate.setAttribute('disabled','disabled');
        totalPrice.innerHTML = tPrice;
        sellPrice.innerHTML = sPrice;
        fetch(`${BASE_URL}sales/date/${fromDate}/${toDate}`,{
          headers:{
            'token' : token
          }
        })
        .then(response => response.json())
        .then(data => {
          hideLoadingAnimation();
          btnFetchProduct.classList.remove('disabled');
          elemFromDate.removeAttribute('disabled','disabled');
          elemToDate.removeAttribute('disabled','disabled');
          if(!data.error)
          {
            let sales = data.sales;
            sales.forEach(sale => {
              tPrice = sale.saleQuantity*sale.productPrice;
              finalTPrice = finalTPrice + tPrice;
              finalSPrice = finalSPrice + sale.salePrice;
              count++;
              let tr = `<tr><td>${count}</td><td>${sale.productCategory}</td><td class="blue-text darken-4">${sale.productName}</td><td style="font-weight:bold">${sale.productSize}</td><td>${sale.productPrice}</td><td>${sale.saleQuantity}</td><td>${tPrice}</td><td>${sale.saleDiscount} </td><td class="blue-text darken-4">${sale.productPrice}  </td><td class="blue-text darken-4">${sale.productBrand}</td><td>${sale.productManufacture}</td><td class="red-text">${sale.productExpire}</td><td>${sale.createdAt}</td></tr>`;
              trList = trList + tr; 
              tableBody.innerHTML='';
            })
            hideLoadingAnimation();
            tableBody.innerHTML = trList;
            totalPrice.innerHTML = finalTPrice;
            sellPrice.innerHTML = finalSPrice;
          }
          else
          {
            tableBody.innerHTML = '';
            makeToast('error',data.message);
          }
        });
      }

      function getAllProduct()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let totalAmountOfSingleProduct = 0;
        let totalAmount = 0;
        let productName= document.getElementById('productName');
        let divProcess= document.getElementById('divProcess');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        let elemTotalAmount = document.getElementById('totalAmount');
        elemTotalAmount.innerHTML = totalAmount;
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/products`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let products = response.products;
            products.forEach((product)=>{
              totalAmountOfSingleProduct = product.productQuantity * product.productPrice;
              totalAmount = totalAmount + totalAmountOfSingleProduct;
              count++;
              let tr = `<tr><td>${count}</td><td>${product.productBrand}</td><td class="blue-text darken-4 bold">${product.productName}</td><td style="font-weight:bold">${product.productSize}</td><td class="blue-text darken-4 bold">${product.productPrice}</td><td>${product.productQuantity}</td><td>${product.productLocation}</td><td class="blue-text darken-4"><span class="chip blue white-text">${product.productBrand}</span></td><td>${product.productManufacture}</td><td class="red-text">${product.productExpire}</td><td><a href="editproduct?pid=${product.productId}" style="border: 1px solid white;border-radius: 50%;" class="btn red"><i class="material-icons white-text">edit</i></a></td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
            elemTotalAmount.innerHTML = totalAmount;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getNoticeProducts()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let totalAmountOfSingleProduct = 0;
        let totalAmount = 0;
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        let elemTotalAmount = document.getElementById('totalAmount');
        elemTotalAmount.innerHTML = totalAmount;
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/products/notice`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let products = response.products;
            products.forEach((product)=>{
              totalAmountOfSingleProduct = product.productQuantity * product.productPrice;
              totalAmount = totalAmount + totalAmountOfSingleProduct;
              count++;
              let tr = `<tr><td>${count}</td><td>${product.productBrand}</td><td class="blue-text darken-4 bold">${product.productName}</td><td style="font-weight:bold">${product.productSize}</td><td class="blue-text darken-4 bold">${product.productPrice}</td><td>${product.productQuantity}</td><td>${product.productLocation}</td><td class="blue-text darken-4"><span class="chip blue white-text">${product.productBrand}</span></td><td>${product.productManufacture}</td><td class="red-text">${product.productExpire}</td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
            elemTotalAmount.innerHTML = totalAmount;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getExpiringProducts()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let totalAmountOfSingleProduct = 0;
        let totalAmount = 0;
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        let elemTotalAmount = document.getElementById('totalAmount');
        elemTotalAmount.innerHTML = totalAmount;
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/products/expiring`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let products = response.products;
            products.forEach((product)=>{
              totalAmountOfSingleProduct = product.productQuantity * product.productPrice;
              totalAmount = totalAmount + totalAmountOfSingleProduct;
              count++;
              let tr = `<tr><td>${count}</td><td>${product.productBrand}</td><td class="blue-text darken-4 bold">${product.productName}</td><td style="font-weight:bold">${product.productSize}</td><td class="blue-text darken-4 bold">${product.productPrice}</td><td>${product.productQuantity}</td><td>${product.productLocation}</td><td class="blue-text darken-4"><span class="chip blue white-text">${product.productBrand}</span></td><td>${product.productManufacture}</td><td class="red-text">${product.productExpire}</td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
            elemTotalAmount.innerHTML = totalAmount;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getExpiredProducts()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let totalAmountOfSingleProduct = 0;
        let totalAmount = 0;
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        let elemTotalAmount = document.getElementById('totalAmount');
        elemTotalAmount.innerHTML = totalAmount;
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/products/expired`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let products = response.products;
            products.forEach((product)=>{
              totalAmountOfSingleProduct = product.productQuantity * product.productPrice;
              totalAmount = totalAmount + totalAmountOfSingleProduct;
              count++;
              let tr = `<tr><td>${count}</td><td>${product.productBrand}</td><td class="blue-text darken-4 bold">${product.productName}</td><td style="font-weight:bold">${product.productSize}</td><td class="blue-text darken-4 bold">${product.productPrice}</td><td>${product.productQuantity}</td><td>${product.productLocation}</td><td class="blue-text darken-4"><span class="chip blue white-text">${product.productBrand}</span></td><td>${product.productManufacture}</td><td class="red-text">${product.productExpire}</td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
            elemTotalAmount.innerHTML = totalAmount;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getProductsRecord()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/products/records`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let products = response.products;
            products.forEach((product)=>{
              count++;
              let tr = `<tr><td>${count}</td><td>${product.productBrand}</td><td class="blue-text darken-4 bold">${product.productName}</td><td style="font-weight:bold">${product.productSize}</td><td class="blue-text darken-4 bold">${product.productPrice}</td><td>${product.productQuantity}</td><td>${product.productLocation}</td><td class="blue-text darken-4"><span class="chip blue white-text">${product.productBrand}</span></td><td>${product.productManufacture}</td><td class="red-text">${product.productExpire}</td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      // We are not using this fucntion,
      function getAvailableProducts()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        // tableBody.innerHTML = '';
        fetch(`${BASE_URL}/products/available`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let products = response.products;
            products.forEach((product)=>{
              count++;
              let tr = `<tr><td>${count}</td><td>${product.productBrand}</td><td class="blue-text darken-4 bold">${product.productName}</td><td style="font-weight:bold">${product.productSize}</td><td class="blue-text darken-4 bold">${product.productPrice}</td><td>${product.productQuantity}</td><td>${product.productLocation}</td><td class="blue-text darken-4"><span class="chip blue white-text">${product.productBrand}</span></td><td>${product.productManufacture}</td><td class="red-text">${product.productExpire}</td></tr>`;
              trList = trList + tr;
            });
            // hideLoadingAnimation();
            productName.removeAttribute('disabled');
            firdos();
            // tableBody.innerHTML = trList;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getCredits()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let productName= document.getElementById('productName')
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';
        showLoadingAnimation();
        fetch(`${BASE_URL}/credits`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let credits = response.credits;
            credits.forEach((credit)=>{
              count++;
              let tr = `<tr><td>${count}</td><td class="blue-text darken-4">${credit.creditor.creditorName}</td><td class="blue-text darken-4 chip red white-text" style="margin-top:17px;">${credit.creditStatus}</td><td>${credit.creditTotalAmount}</td><td>${credit.creditPaidAmount}</td><td>${credit.creditRemainingAmount}</td><td class="blue-text darken-4">${credit.creditDate}</td><td><a href="credit?cid=${credit.creditId}" style="border: 1px solid white;border-radius: 50%;" class="btn blue" data-position="top" data-tooltip="View credit"><i class="material-icons white-text">remove_red_eye</i></a></td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getTodaysSalesRecord()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let totalAmountOfSingleProduct = 0;
        let totalAmount = 0;
        let saleAmount = 0;
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        let elemTotalAmount = document.getElementById('totalAmount');
        let elemSaleAmount = document.getElementById('saleAmount');
        elemSaleAmount.innerHTML = saleAmount; 
        elemTotalAmount.innerHTML = totalAmount;
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/sales/today`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let sales = response.sales;
            sales.forEach((sale)=>{
              totalAmountOfSingleProduct = sale.saleQuantity * sale.productPrice;
              totalAmount = totalAmount + totalAmountOfSingleProduct;
              saleAmount = saleAmount + sale.salePrice;
              count++;
              let tr = `<tr id="rowId${sale.saleId}"><td>${count}</td><td>${sale.productCategory}</td><td class="blue-text darken-4">${sale.productName}</td><td style="font-weight:bold">${sale.productSize}</td><td>${sale.productPrice}</td><td>${sale.saleQuantity}</td><td class="blue-text darken-4">${totalAmountOfSingleProduct}</td><td>${sale.saleDiscount}% </td><td>${sale.salePrice} </td><td class="blue-text darken-4">${sale.productBrand}</td><td>${sale.productManufacture}</td><td class="red-text">${sale.productExpire}</td><td class="center">${sale.createdAt}</td><td><button id="btnDelete${sale.saleId}" value="${sale.saleId}" onclick="alertDeleteSaleProduct(this.value)" style="border: 1px solid white;border-radius: 50%;" class="btn red"><i class="material-icons white-text">delete_forever</i></button></td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
            elemTotalAmount.innerHTML = totalAmount;
            elemSaleAmount.innerHTML = saleAmount;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getInvoices()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/invoices`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          if(!response.error)
          {
            let invoices = response.invoices;
            invoices.forEach((invoice)=>{
              count++;
              let tr = `<tr><td>${count}</td><td><img src="${invoice.sellerImage}" class="circle" style="width:50px; height:50px; border:2px solid red"></td><td class="blue-text darken-4">${invoice.sellerName}</td><td style="font-weight:bold">${invoice.invoiceNumber}</td><td class="blue-text darken-4 chip blue white-text" style="margin-top:25px;">${invoice.invoiceStatus}</td><td>${invoice.invoiceAmount}</td><td>${invoice.invoicePaidAmount}</td><td>${invoice.invoiceRemainingAmount}</td><td class="blue-text darken-4">${invoice.invoiceDate}</td><td><a href="invoice?inum=${invoice.invoiceNumber}" style="border: 1px solid white;border-radius: 50%;" class="btn blue" data-position="top" data-tooltip="View Invoice"><i class="material-icons white-text">remove_red_eye</i></a><a href="payment?inum=${invoice.invoiceNumber}" style="border: 1px solid white;border-radius: 50%;" class="btn red" data-position="top" data-tooltip="Pay Amount"><i class="material-icons white-text">attach_money</i></a></td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }

      function getAllSellers()
      {
        showLoadingAnimation();
        let count = 0;
        let trList = '';
        let sellerImage = 'src/img/user.png';
        let productName= document.getElementById('productName');
        productName.setAttribute('disabled','disabled');
        let tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';
        fetch(`${BASE_URL}/sellers`,{
          headers:{
            token:token
          }
        })
        .then(response=>response.json())
        .then(response=>{
          console.log(response);
          if(!response.error)
          {
            let sellers = response.sellers;
            sellers.forEach((seller)=>{
              count++;
              if(seller.sellerImage!=null)
                sellerImage = seller.sellerImage;
              else
                sellerImage =  'src/img/user.png';
              let tr = `<tr><td>${count}</td><td><a href="seller?sid=${seller.sellerId}"><img src="${sellerImage}" class="circle" style="width:50px; height:50px; border:2px solid red"></a></td><td class="blue-text darken-4"><a href="seller?sid=${seller.sellerId}">${seller.sellerName}</a></td><td style="font-weight:bold"></td><td class="blue-text darken-4">${seller.sellerContactNumber} , ${seller.sellerContactNumber1}</td><td>${seller.sellerAddress}</td></tr>`;
              trList = trList + tr;
            });
            hideLoadingAnimation();
            productName.removeAttribute('disabled');
            tableBody.innerHTML = trList;
          }
          else
            $('.socialcodia').html(getError(response.message));
        });
      }


      function chartTopProductsRecordYearly()
      {
        let ctx = document.getElementById('chartTopProductsRecordYearly').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"sales/status/products/yearly",
         success:function(response)
         {
          
          if(!response.error)
          {
            let products = response.products;
            let labels = products.map((e)=>{
              return e.productName;
            });

            let data = products.map((e)=>
            {
              return e.saleQuantity;
            });
            let chartTopProductsRecordYearly = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: ['TOP 10 Selling Products Of This Year'],
                  data: data,
                  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                  borderColor: ['black','black','black','black','black','black',]
                }]
              }
            });
          }
          else
            makeToast('error',response.message);
        }
      });
      }

      function getSalesStatusByDays()
      {
        let ctx = document.getElementById('chatSalesRecordOfDays').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"sales/status/days",
         success:function(response)
         {
          
          if(!response.error)
          {
            let status = response.status;
            let labels = status.map((e)=>{
              return e.day;
            });

            let data = status.map((e)=>
            {
              return e.totalSales;
            });
            let chatSalesRecordOfDays = new Chart(ctx, {
              type: 'line',
              data: {
                labels: labels,
                datasets: [{
                  label: ['Daily Sales'],
                  data: data,
                  backgroundColor: "#3e95cd"
                }]
              }
            });
          }
          else
            makeToast('error',response.message);
        }
      });
      }

      function setSellerIncome()
      {
        let url = new URL(window.location.href);
        var sellerId = url.searchParams.get('sid');
        let ctx = document.getElementById('chartSellerIncome').getContext('2d');
        $.ajax({
          headers:{  
           'token':token
         },
         type:"get",
         url:BASE_URL+"seller/"+sellerId+"/income",
         success:function(response)
         {
          
          if(!response.error)
          {
            let incomes = response.incomes;
            let labels = incomes.map((e)=>{
              return e.monthName;
            });

            let data = incomes.map((e)=>
            {
              return e.netProfit;
            });

            let data1 = incomes.map((e)=>
            {
              return e.maxProfit;
            });
            let chartSellerIncome = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: ['Min Income'],
                  data: data,
                  backgroundColor: "red"
                },{
                  label: ['Max Income'],
                  data: data1,
                  backgroundColor: "#3e95cd"
                }]
              }
            });
          }
          else
            makeToast('error',response.message);
        }
      });
      }

      let productTable = document.getElementById('productTable');
      let tableBody = document.getElementById('tableBody');

   function firdos()
   {
       if ((endPathname=='sell') || (endPathname=='selltoseller'))
      {
        (function() {
          var trows = document.getElementById('mstrTable').rows, t = trows.length, trow, nextrow,
    // rownum = document.getElementById('rownum'),
    addEvent = (function(){return window.addEventListener? function(el, ev, f){
            el.addEventListener(ev, f, false); //modern browsers
          }:window.attachEvent? function(el, ev, f){
            el.attachEvent('on' + ev, function(e){f.apply(el, [e]);}); //IE 8 and less
        }:function(){return;}; //a very old browser (IE 4 or less, or Mozilla, others, before Netscape 6), so let's skip those
      })();

      function option(num){
      // console.log(num);
        // var o = document.createElement('option');
        // o.value = num;
        // rownum.insertBefore(o, rownum.options[1]); //IE 8 and less, must insert to page before setting text property
        let o = trows[num].cells[0].innerHTML + ' (' + num + ')';
        return o;
      }

    // function rownumchange(){
    //     if(this.value > 0){ //activates the highlight function for the selected row (highlights it)
    //         highlightRow.apply(trows[this.value]);
    //     } else { //activates the highlight function for the row that is currently highlighted (turns it off)
    //         highlightRow.apply(trows[highlightRow(true)]);
    //     }
    //     this.blur(); //prevent Mozilla from firing on internal events that change rownum's value
    // }

    // addEvent(rownum, 'change', rownumchange);

    // rownum.value = 0; //reset for browsers that remember select values on reload

    while (--t > 0) {
      trow = trows[t];
      trow.className = 'normal';
      addEvent(trow, 'click', highlightRow);
      option(t);
    }//end while

    function highlightRow(gethighlight) { //now dual use - either set or get the highlighted row
      gethighlight = gethighlight === true;
      var t = trows.length;
      while (--t > 0) {
        trow = trows[t];
        if(gethighlight && trow.className === 'highlighted'){return t;}
        else if (!gethighlight){
          if(trow !== this) { trow.className = 'normal'; }
                // else if(this.className === 'normal') { rownum.value = t; }
                // else { rownum.value = 0; }
              }
        }//end while

        return gethighlight? null : this.className = this.className === 'highlighted'? 'normal' : 'highlighted';
    }//end function

    function movehighlight(way, e){
      e.preventDefault && e.preventDefault();
      e.returnValue = false;
          var idx = highlightRow(true); //gets current index or null if none highlighted
          // console.log(idx);
          if(typeof idx === 'number'){//there was a highlighted row
              idx += way; //increment\decrement the index value
              
              if(idx && (nextrow = trows[idx])){ return highlightRow.apply(nextrow); } //index is > 0 and a row exists at that index
              else if(idx){ return highlightRow.apply(trows[1]); } //index is out of range high, go to first row
              return highlightRow.apply(trows[trows.length - 1]); //index is out of range low, go to last row
            }
          return highlightRow.apply(trows[way > 0? 1 : trows.length - 1]); //none was highlighted - go to 1st if down arrow, last if up arrow
      }//end function

      function processkey(e){
        switch(e.keyCode){
              case 38: {//up arrow
                return movehighlight(-1, e);
              }
              case 40: {//down arrow
                return movehighlight(1, e);
              }
              case 13: {//down arrow
               let o = highlightRow(true);
               let pid = trows[o].childNodes[1].id;
               if ($('#modal1').hasClass('open'))
               {
                let inputInvoiceNumber = document.getElementById('inputInvoiceNumber');
                if (endPathname=='sell')
                  sellProduct(pid);
                else if (endPathname=='selltoseller')
                  sellToSeller(pid,inputInvoiceNumber.value);
              }
              closeModal();
                   // $("td",trow).each(function(){
                   //  //access the value as
                   //   console.log($(this).html());
                   //  });
                 }
                 default: {
                  return true;
                }
              }
      }//end function

      addEvent(document, 'keydown', processkey);
      addEvent(window, 'unload', function(){}); //optional, resets the page for browsers that remember the script state on back and forward buttons

    }/* end function */)();//execute function and end script
  }
   }

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

    // document.addEventListener("DOMContentLoaded", getCategories());

    function filterProduct() {
      var input, filter, table, tr, td, cell, i, j;
      input = document.getElementById("productName");
      filter = input.value.toUpperCase();
      table = document.getElementById("mstrTable");
      tr = table.getElementsByTagName("tr");
      for (i = 1; i < tr.length; i++) {
        // Hide the row initially.
        tr[i].style.display = "none";

        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
          cell = tr[i].getElementsByTagName("td")[j];
          if (cell) {
            if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
              break;
            } 
          }
        }
      }
    }

    function updateProduct()
    {
      let selectBrand = document.getElementById('selectBrand');
      let selectCategory = document.getElementById('selectCategory');
      let selectSize = document.getElementById('selectSize');
      let manMonth = document.getElementById('manMonth');
      let manYear = document.getElementById('manYear');
      let expMonth = document.getElementById('expMonth');
      let expYear = document.getElementById('expYear');
      let selectItem = document.getElementById('selectItem');
      let productPrice = document.getElementById('productPrice');
      let productQuantity = document.getElementById('productQuantity');
      let productId = document.getElementById('productId');
      let productBarCode = document.getElementById('productBarCode');
      let btnUpdateProduct = document.getElementById('btnUpdateProduct');
      if (productId.value<1)
      {
        makeToast('error',"Please Refresh The Page");
        return;
      }
      if (selectBrand.value<1)
      {
        makeToast('error','Select Brand');
        return;
      }
      if (selectCategory.value<1)
      {
        makeToast('error','Select Category');
        return;
      }
      if (selectSize.value<1)
      {
        makeToast('error','Select Size');
        return;
      }
      if (selectLocation.value<1)
      {
        makeToast('error','Select Location');
        return;
      }
      if (selectItem.value<1)
      {
        makeToast('error','Select Item Name');
        return;
      }
      if (productPrice.value=='')
      {
        makeToast('error','Enter Price');
        return;
      }
      if (productPrice.value<5)
      {
        makeToast('error','Price too Short');
        return;
      }
      if (productQuantity.value=='')
      {
        makeToast('error','Enter Quantity');
        return;
      }
      if (productQuantity.value<1)
      {
        makeToast('error','Product Quantity too Short');
        return;
      }
      if (manMonth.value<1)
      {
        makeToast('error','Select Manufacture Month');
        return;
      }
      if (manYear.value<1)
      {
        makeToast('error','Select Manufacture Year');
        return;
      }
      if (expMonth.value<1)
      {
        makeToast('error','Select Expire Month');
        return;
      }
      if (expYear.value<1)
      {
        makeToast('error','Select Expire Year');
        return;
      }
      let productManufactureDate = manYear.value+'-'+manMonth.value+'-01';
      let productExpireDate = expYear.value+'-'+expMonth.value+'-01';
      let a = new Date(productManufactureDate);
      let b = new Date(productExpireDate);
      if (a>b)
      {
        makeToast('error','The Manufacture date could not be greater than expire date');
        return;
      }
      btnUpdateProduct.classList.add('disabled');
      
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"product/update",
       data: 
       {  
         'productId' : productId.value,
         'productName' : selectItem.value,
         'productBrand':selectBrand.value,
         'productCategory':selectCategory.value,
         'productSize':selectSize.value,
         'productLocation':selectLocation.value,
         'productPrice':productPrice.value,
         'productQuantity':productQuantity.value,
         'productManufactureDate':productManufactureDate,
         'productExpireDate':productExpireDate,
         'productBarCode':productBarCode.value
       },
       success:function(response)
       {
        
        if (!response.error)
        {
          playSuccess();
          
          makeToast('success',response.message);
          btnUpdateProduct.classList.remove('disabled');
        }
        else
        {
          playWarning();
          productQuantity.value = '';
            // manMonth.selectedIndex = 0;
            // manYear.selectedIndex = 0;
            // expMonth.selectedIndex = 0;
            // expYear.selectedIndex = 0;
            makeToast('error',response.message);
            btnUpdateProduct.classList.remove('disabled');
          }
        }
      });
    }

    function addProduct()
    {
      let selectBrand = document.getElementById('selectBrand');
      let selectCategory = document.getElementById('selectCategory');
      let selectSize = document.getElementById('selectSize');
      let manMonth = document.getElementById('manMonth');
      let manYear = document.getElementById('manYear');
      let expMonth = document.getElementById('expMonth');
      let expYear = document.getElementById('expYear');
      let selectItem = document.getElementById('selectItem');
      let productPrice = document.getElementById('productPrice');
      let productQuantity = document.getElementById('productQuantity');
      let productBarCode = document.getElementById('productBarCode');
      let btnAddProduct = document.getElementById('btnAddProduct');
      
      if (selectBrand.value<1)
      {
        makeToast('error','Select Brand');
        return;
      }
      if (selectCategory.value<1)
      {
        makeToast('error','Select Category');
        return;
      }
      if (selectSize.value<1)
      {
        makeToast('error','Select Size');
        return;
      }
      if (selectLocation.value<1)
      {
        makeToast('error','Select Location');
        return;
      }
      if (selectItem.value<1)
      {
        makeToast('error','Select Item');
        return;
      }
      if (productPrice.value=='')
      {
        makeToast('error','Enter Price');
        return;
      }
      if (productPrice.value<5)
      {
        makeToast('error','Price too Short');
        return;
      }
      if (productQuantity.value=='')
      {
        makeToast('error','Enter Quantity');
        return;
      }
      if (productQuantity.value<1)
      {
        makeToast('error','Quantity too Low');
        return;
      }
      if (manMonth.value<1)
      {
        makeToast('error','Select Manufacture Month');
        return;
      }
      if (manYear.value<1)
      {
        makeToast('error','Select Manufacture Year');
        return;
      }
      if (expMonth.value<1)
      {
        makeToast('error','Select Expire Month');
        return;
      }
      if (expYear.value<1)
      {
        makeToast('error','Select Expire Year');
        return;
      }
      let productManufactureDate = manYear.value+'-'+manMonth.value+'-01';
      let productExpireDate = expYear.value+'-'+expMonth.value+'-01';
      let a = new Date(productManufactureDate);
      let b = new Date(productExpireDate);
      if (a>b)
      {
        makeToast('error','The Manufacture date could not be greater than expire date');
        return;
      }
      btnAddProduct.classList.add('disabled');
      
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"product/add",
       data: 
       {  
         'productName' : selectItem.value,
         'productBrand':selectBrand.value,
         'productCategory':selectCategory.value,
         'productSize':selectSize.value,
         'productLocation':selectLocation.value,
         'productPrice':productPrice.value,
         'productQuantity':productQuantity.value,
         'productManufactureDate':productManufactureDate,
         'productExpireDate':productExpireDate,
         'productBarCode' : productBarCode.value
       },
       success:function(response)
       {
        
        if (!response.error)
        {
          playSuccess();
          
          makeToast('success',response.message);
          productQuantity.value = '';
          btnAddProduct.classList.remove('disabled');
        }
        else
        {
          playWarning();
          makeToast('error',response.message);
          btnAddProduct.classList.remove('disabled');
        }
      }
    });
    }

    function alertMakePayment()
    {
      let paymentAmount = document.getElementById('paymentAmount');
      let sellerName = document.getElementById('sellerName');
      let invoiceNumber = document.getElementById('invoiceNumber');
      paymentAmount = paymentAmount.value;
      invoiceNumber = invoiceNumber.innerHTML;
      sellerName = sellerName.innerHTML;
      if (paymentAmount<=0.99999999)
      {
        makeToast('error','Enter Amount');
        return;
      }
      let text = "<b>The seller <span class='blue-text'>"+sellerName+"</span> is paying you <h4 style='font-weight:bold; color:red'>"+paymentAmount+' Rupees'+"</h4> For Invoice <span class='blue-text'>"+invoiceNumber+"</span></b>";
      Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: `Accept Payment`,
        denyButtonText: `Cancel Payment`,
        html: text
      }).then((result) => {
        if (result.isConfirmed) 
        {
          payAmount();
        }
      });
    }

    function payAmount()
    {
      let btnPayment = document.getElementById('btnPayment');
      let inputPaymentAmount = document.getElementById('paymentAmount');
      let sellerId = document.getElementById('sellerId');
      let invoicePaidAmount = document.getElementById('invoicePaidAmount');
      let invoiceRemainingAmount = document.getElementById('invoiceRemainingAmount');
      let invoiceNumber = document.getElementById('invoiceNumber');
      paymentAmount = inputPaymentAmount.value;
      sellerId = sellerId.innerHTML;
      invoiceNumber = invoiceNumber.innerHTML;
      btnPayment.classList.add('disabled');
      if (paymentAmount<=0.99999999)
      {
        makeToast('error','Enter Amount');
        return;
      }
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"payment/add",
       data: 
       {  
         'paymentAmount' : paymentAmount,
         'sellerId' : sellerId,
         'invoiceNumber' : invoiceNumber
       },
       success:function(response)
       {
        let desc = 'You have added '+paymentAmount+' Rupees';
        
        if (!response.error)
        {
          inputPaymentAmount.value = '';
          invoicePaidAmount.innerHTML = parseInt(invoicePaidAmount.innerHTML)+parseInt(paymentAmount);
          invoiceRemainingAmount.innerHTML = parseInt(invoiceRemainingAmount.innerHTML)-parseInt(paymentAmount);
          playSuccess();
          Swal.fire(
            'Payment Added',
            desc,
            'success'
            )
          btnPayment.classList.remove('disabled');
        }
        else
        {
          makeToast('error',response.message);
          btnPayment.classList.remove('disabled');
        }
      }
    });
    }

    function alertAcceptCreditPayment()
    {
      let paymentAmount = document.getElementById('paymentAmount');
      let creditorName = document.getElementById('creditorName');
      let creditDate = document.getElementById('creditDate');
      paymentAmount = paymentAmount.value;
      creditDate = creditDate.innerHTML;
      creditorName = creditorName.innerHTML;
      if (paymentAmount<=0.99999999)
      {
        makeToast('error','Enter Amount');
        return;
      }
      let text = "<b>The Creditor <span class='blue-text'>"+creditorName+"</span> is paying you <h4 style='font-weight:bold; color:red'>"+paymentAmount+' Rupees'+"</h4> For credit which they have taken on <span class='blue-text'>"+creditDate+"</span></b>";
      Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: `Accept Payment`,
        denyButtonText: `Cancel Payment`,
        html: text
      }).then((result) => {
        if (result.isConfirmed) 
        {
          acceptCreditAmount();
        }
      });
    }

    function acceptCreditAmount()
    {
      let btnPayment = document.getElementById('btnPayment');
      let inputPaymentAmount = document.getElementById('paymentAmount');
      let creditPaidAmount = document.getElementById('creditPaidAmount');
      let creditRemainingAmount = document.getElementById('creditRemainingAmount');
      let creditId = document.getElementById('creditId');
      paymentAmount = inputPaymentAmount.value;
      creditId = creditId.innerHTML;
      btnPayment.classList.add('disabled');
      if (paymentAmount<=0.99999999)
      {
        makeToast('error','Enter Amount');
        return;
      }
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"credit/payment/add",
       data: 
       {  
         'paymentAmount' : paymentAmount,
         'creditId' : creditId
       },
       success:function(response)
       {
        let desc = 'You have added '+paymentAmount+' Rupees';
        
        if (!response.error)
        {
          inputPaymentAmount.value = '';
          creditPaidAmount.innerHTML = parseInt(creditPaidAmount.innerHTML)+parseInt(paymentAmount);
          creditRemainingAmount.innerHTML = parseInt(creditRemainingAmount.innerHTML)-parseInt(paymentAmount);
          playSuccess();
          Swal.fire(
            'Payment Added',
            desc,
            'success'
            )
          btnPayment.classList.remove('disabled');
        }
        else
        {
          makeToast('error',response.message);
          btnPayment.classList.remove('disabled');
        }
      }
    });
    }

    function deleteSoldProduct(value)
    {
      let btnDelete = document.getElementById('btnDelete'+value);
      let row = document.getElementById('rowId'+value);
      btnDelete.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"product/sell/delete",
       data: 
       {  
         'sellId' : value
       },
       success:function(response)
       {
        
        if (!response.error)
        {
          playSuccess();
          row.remove();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          btnDelete.classList.remove('disabled');
          sumColumn();
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnDelete.classList.remove('disabled');
        }
      }
    });
    }

    function deleteSellerSoldProduct(value)
    {
      let btnDelete = document.getElementById('btnDelete'+value);
      let row = document.getElementById('rowId'+value);
      btnDelete.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"seller/product/sell/delete",
       data: 
       {  
         'sellId' : value
       },
       success:function(response)
       {
        
        if (!response.error)
        {
          playSuccess();
          row.remove();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          btnDelete.classList.remove('disabled');
          sumColumn();
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnDelete.classList.remove('disabled');
        }
      }
    });
    }

    function alertDeleteSaleProduct(value)
    {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure want to delete this sale entry',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete Entry'
      }).then((result) => {
        if (result.isConfirmed) 
        {
          deleteSoldProduct(value);
        }
      });
    }

    function alertDeleteSellerSaleProduct(value)
    {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure want to delete this sale entry',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete Entry'
      }).then((result) => {
        if (result.isConfirmed) 
        {
          deleteSellerSoldProduct(value);
        }
      });
    }

    function alertUpdateProduct()
    {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure want to update this product.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Update Product'
      }).then((result) => {
        if (result.isConfirmed) 
          updateProduct();
      });
    }

    function addItem()
    {
      let itemName = document.getElementById('itemName');
      let itemDescription = document.getElementById('itemDescription');
      let btnAddItem = document.getElementById('btnAddItem');
      if (itemName.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Item Name"
        });
        return;
      }
      if (itemName.value.length<3)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Item Name Too Short"
        });
        return;
      }
      btnAddItem.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"item/add",
       data: 
       {  
         'itemName' : itemName.value,
         'itemDescription' : itemDescription.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          fetchItemAgain();
          itemName.value = '';
          itemDescription.value = '';
          makeToast('success',response.message);
          btnAddItem.classList.remove('disabled');
        }
        else
        {
          makeToast('error',response.message);
          btnAddItem.classList.remove('disabled');
        }
      }
    });
    }

    function addBrand()
    {
      let brandName = document.getElementById('brandName');
      let btnAddBrand = document.getElementById('btnAddBrand');
      if (brandName.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Brand Name"
        });
        return;
      }
      if (brandName.value.length<3)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Brand Name too short"
        });
        return;
      }
      btnAddBrand.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"brand/add",
       data: 
       {  
         'brandName' : brandName.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          playSuccess();
          brandName.value = '';
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          btnAddBrand.classList.remove('disabled');
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnAddBrand.classList.remove('disabled');
        }
      }
    });
    }

    let count = 1;
    function sellProduct(value)
    {
      // let brandName = document.getElementById('brandName');
      let SellRecordTableBody = document.getElementById('SellRecordTableBody');
      if (value=='')
      {
        playError();
        Toast.fire({
          icon: 'error',
          title: "Failed To Fetch Product Id"
        });
        return;
      }

      // btnAddBrand.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"product/sell",
       data: 
       {  
         'productId' : value
       },
       success:function(response)
       {
        
        if (!response.error)
        {
          playSuccess();
          let product = response.product;
          let tr = document.createElement('tr');
          tr.id = 'rowId'+product.saleId;
          let tdSr = '<td>'+count+'</td>';
          let tdSId = '<td class="hide"><input type="text" id="saleId'+product.saleId+'" value="'+product.saleId+'" readonly="readonly"></td>';
          let tdPName = '<td id="productName'+product.saleId+'">'+product.productName+'</td>';
          let tdPSize = '<td>'+product.productSize+'</td>';
          let tdPPrice = '<td id="productPrice'+product.saleId+'">'+product.productPrice+'</td>';
          let tdPQuantity = '<td><input class="center" type="number" onkeyup="changePrice(this.value)" style="width:40px;" id="productQuantity'+product.saleId+'" value="1"></td>';
          let tdAPQuantity = '<td class="hide" id="productAllQuantity'+product.saleId+'">'+product.productQuantity+'</td>';
          let tdPTPrice = '<td Id="productTotalPrice'+product.saleId+'">'+product.productPrice+'</td>';
          let tdPSellDiscount = '<td ><input class="center" type="number" onkeyup="discountInputEvent(this.value)" style="width:60px;" id="productDiscount'+product.saleId+'" value="0"></td>';
          let tdPSellPrice = '<td><input type="number" onkeyup="priceEvent(this.value)" style="width:60px;" id="productSellPrice'+product.saleId+'" value="'+product.productPrice+'"></td>';
          let tdPBrand = '<td>'+product.productBrand+'</td>';
          let tdPAction = '<td><button style="border: 1px solid white;border-radius: 50%; display:none" onclick="updateSellRecord(this.value)" value="'+product.saleId+'" id="btnUpdate'+product.saleId+'" class="btn blue"><i class="material-icons white-text large">check_circle</i></button><button id="btnDelete'+product.saleId+'" value="'+product.saleId+'" onclick="alertDeleteSaleProduct(this.value)" style="border: 1px solid white;border-radius: 50%;" class="btn red"><i class="material-icons white-text">delete_forever</i></button></td>';
          tr.innerHTML=tdSr+tdSId+tdPName+tdPSize+tdPPrice+tdPQuantity+tdAPQuantity+tdPTPrice+tdPSellDiscount+tdPSellPrice+tdPBrand+tdPAction;
          SellRecordTableBody.appendChild(tr);
            // Toast.fire({
            //       icon: 'success',
            //       title: response.message
            //   });
            // btnAddBrand.classList.remove('disabled');
            count++;
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            // btnAddBrand.classList.remove('disabled');
          }
          sumColumn();

        }
      });
    }

    function sellToSeller(value,invoiceNumber)
    {
      // let brandName = document.getElementById('brandName');
      let SellRecordTableBody = document.getElementById('SellRecordTableBody');
      if (value=='')
      {
        playError();
        Toast.fire({
          icon: 'error',
          title: "Failed To Fetch Product Id"
        });
        return;
      }

      // btnAddBrand.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"seller/product/sell",
       data: 
       {  
         'productId' : value,
         'invoiceNumber':invoiceNumber
       },
       success:function(response)
       {
        
        if (!response.error)
        {
          playSuccess();
          let product = response.product;
          let tr = document.createElement('tr');
          tr.id = 'rowId'+product.saleId;
          let tdSr = '<td>'+count+'</td>';
          let tdSId = '<td class="hide"><input type="text" id="saleId'+product.saleId+'" value="'+product.saleId+'" readonly="readonly"></td>';
          let tdPName = '<td id="productName'+product.saleId+'">'+product.productName+'</td>';
          let tdPSize = '<td>'+product.productSize+'</td>';
          let tdPPrice = '<td id="productPrice'+product.saleId+'">'+product.productPrice+'</td>';
          let tdPQuantity = '<td><input class="center" type="number" onkeyup="changePrice(this.value)" style="width:40px;" id="productQuantity'+product.saleId+'" value="1"></td>';
          let tdAPQuantity = '<td class="hide" id="productAllQuantity'+product.saleId+'">'+product.productQuantity+'</td>';
          let tdPTPrice = '<td Id="productTotalPrice'+product.saleId+'">'+product.productPrice+'</td>';
          let tdPSellDiscount = '<td><input class="center" type="number" onkeyup="discountInputEvent(this.value)" style="width:60px;" id="productDiscount'+product.saleId+'" value="0"></td>';
          let tdPSellPrice = '<td><input type="number" onkeyup="priceEvent(this.value)" style="width:60px;" id="productSellPrice'+product.saleId+'" value="'+product.productPrice+'"></td>';
          let tdPBrand = '<td>'+product.productBrand+'</td>';
          let tdPAction = '<td><button style="border: 1px solid white;border-radius: 50%; display:none" onclick="updateSellerSellRecord(this.value)" value="'+product.saleId+'" id="btnUpdate'+product.saleId+'" class="btn blue"><i class="material-icons white-text large">check_circle</i></button><button id="btnDelete'+product.saleId+'" value="'+product.saleId+'" onclick="alertDeleteSellerSaleProduct(this.value)" style="border: 1px solid white;border-radius: 50%;" class="btn red"><i class="material-icons white-text">delete_forever</i></button></td>';
          tr.innerHTML=tdSr+tdSId+tdPName+tdPSize+tdPPrice+tdPQuantity+tdAPQuantity+tdPTPrice+tdPSellDiscount+tdPSellPrice+tdPBrand+tdPAction;
          SellRecordTableBody.appendChild(tr);
            // Toast.fire({
            //       icon: 'success',
            //       title: response.message
            //   });
            // btnAddBrand.classList.remove('disabled');
            count++;
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
            // btnAddBrand.classList.remove('disabled');
          }
          sumColumn();
        }
      });
    }

    function updateSellRecord(value)
    {
      let btnUpdate =  document.getElementById('btnUpdate'+value);
      let productQuantity =  document.getElementById('productQuantity'+value);
      let productAllQuantity = document.getElementById('productAllQuantity'+value);
      let productSellPrice =  document.getElementById('productSellPrice'+value);
      let productName = document.getElementById('productName'+value);
      let productDiscount = document.getElementById('productDiscount'+value);
      let quantity = productQuantity.value;
      let price = productSellPrice.value;
      let discount = productDiscount.value;
      if (quantity<1)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: 'Product Quantity Is Low'
        });
        return;
      }
      btnUpdate.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"product/sell/update",
       data:{
        'saleId':value,
        'productQuantity':quantity,
        'productSellDiscount':discount,
        'productSellPrice':price
      },
      success:function(response)
      {
        btnUpdate.classList.remove('disabled');
        
        if (!response.error)
        {
          btnUpdate.style.display = 'none';
          playSuccess(); 
          Toast.fire({
            icon: 'success',
            title: response.message
          });
        }
        else
        {
          playError();
          if (new String(response.message).valueOf() == new String("Product Not Available").valueOf())
          {
            let productAC = parseInt(productAllQuantity.innerText)+1;
            let text = "<b>The Available Quantity Of <span class='blue-text'>"+productName.innerText+"</span> Is <h4 style='font-weight:bold; color:red'>"+productAC+"</h4>Please Decrease The Quantity.</b>";
            Swal.fire({
              icon: 'warning',
              title: response.message,
              html: text
            });
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      }
    });
    }

    function updateSellerSellRecord(value)
    {
      let btnUpdate =  document.getElementById('btnUpdate'+value);
      let productQuantity =  document.getElementById('productQuantity'+value);
      let productAllQuantity = document.getElementById('productAllQuantity'+value);
      let productSellPrice =  document.getElementById('productSellPrice'+value);
      let productDiscount =  document.getElementById('productDiscount'+value);
      let productName = document.getElementById('productName'+value);
      let quantity = productQuantity.value;
      let price = productSellPrice.value;
      let discount = productDiscount.value;
      if (quantity<1)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: 'Product Quantity Is Low'
        });
        return;
      }
      btnUpdate.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"seller/product/sell/update",
       data:{
        'saleId':value,
        'productQuantity':quantity,
        'productSellPrice':price,
        'sellDiscount':discount,
      },
      success:function(response)
      {
        btnUpdate.classList.remove('disabled');
        
        if (!response.error)
        {
          btnUpdate.style.display = 'none';
          playSuccess(); 
          Toast.fire({
            icon: 'success',
            title: response.message
          });
        }
        else
        {
          playError();
          if (new String(response.message).valueOf() == new String("Product Not Available").valueOf())
          {
            let productAC = parseInt(productAllQuantity.innerText)+1;
            let text = "<b>The Available Quantity Of <span class='blue-text'>"+productName.innerText+"</span> Is <h4 style='font-weight:bold; color:red'>"+productAC+"</h4>Please Decrease The Quantity.</b>";
            Swal.fire({
              icon: 'warning',
              title: response.message,
              html: text
            });
          }
          else
          {
            playWarning();
            Toast.fire({
              icon: 'error',
              title: response.message
            });
          }
        }
      }
    });
    }

    //calling this function on change quantity
    function changePrice(quantity)
    {
      quantity = parseInt(quantity);
      let sellId = $(event.target)[0].id.replace('productQuantity','');
      let productTotalPrice = document.getElementById('productTotalPrice'+sellId);
      let productPrice = document.getElementById('productPrice'+sellId);
      let productSellPrice = document.getElementById('productSellPrice'+sellId);
      let productQuantity = document.getElementById('productQuantity'+sellId);
      let btnUpdateProduct = document.getElementById('btnUpdate'+sellId);
      let inputProductDiscount = document.getElementById('productDiscount'+sellId);
      btnUpdateProduct.style.display = 'block';
      if(quantity<1)
      {
        productQuantity.value = 1;
        quantity = 1;
      }
      let price = parseInt(productPrice.innerText);
      let fPrice = price*quantity;
      productTotalPrice.innerHTML = fPrice;
      productSellPrice.value = percentageDec(fPrice,inputProductDiscount.value);
      sumColumn();

    }

    //calling this function on change percentage input
    function discountInputEvent(value)
    {
      let sellId = $(event.target)[0].id.replace('productDiscount','');
      let inputProductTotalPrice = document.getElementById('productTotalPrice'+sellId);
      let inputProductSellPrice = document.getElementById('productSellPrice'+sellId);
      let inputProductDiscount = document.getElementById('productDiscount'+sellId);
      let totalPrice = parseInt(inputProductTotalPrice.innerText);
      let productDiscount = inputProductDiscount.value;
      inputProductSellPrice.value = percentageDec(totalPrice,productDiscount);
      sumColumn();
      btnUpdateShow();
    }

    //calling this function on sell price change input
    function priceEvent(value)
    {
      let sellId = $(event.target)[0].id.replace('productSellPrice','');
      let inputProductTotalPrice = document.getElementById('productTotalPrice'+sellId);
      let inputProductSellPrice = document.getElementById('productSellPrice'+sellId);
      let inputProductDiscount = document.getElementById('productDiscount'+sellId);
      let btnUpdateProduct = document.getElementById('btnUpdate'+sellId);
      if (endPathname=='selltoseller' || endPathname=='sell')
        inputProductDiscount.value = percentage(inputProductSellPrice.value,inputProductTotalPrice.innerText);
      btnUpdateProduct.style.display = 'block';
      sumColumn();
    }

    function btnUpdateShow()
    {
      let sellId = $(event.target)[0].id.replace('productDiscount','');
      let btnUpdateProduct = document.getElementById('btnUpdate'+sellId);
      btnUpdateProduct.style.display = 'block';
    }

    function btnUpdateHide()
    {
      let sellId = $(event.target)[0].id.replace('productDiscount','');
      let btnUpdateProduct = document.getElementById('btnUpdate'+sellId);
      btnUpdateProduct.style.display = 'none';
    }

    function percentage(partialValue, totalValue)
    {
      let per = (100 * partialValue) / totalValue;
      return parseInt(100-per);
    } 

    function percentageDec(totalValue, per)
    {
      let htmlTotalPrice = document.getElementById('htmlTotalPrice');
      let htmlDiscountPrice = document.getElementById('htmlDiscountPrice');
      return (totalValue - ((per /100) * totalValue));
    }

    function sumColumn()
    {
      let total = 0;
      let sellTotal = 0;
      let htmlTotalPrice = document.getElementById('htmlTotalPrice');
      let htmlDiscountPrice = document.getElementById('htmlDiscountPrice');
      let table = document.getElementById('productTable');
      for(let i = 1; i < table.rows.length; i++)
      {
        let tbl = table.rows[i].cells[7];
        if (tbl.children.length>0)
          total = total + parseInt(tbl.firstChild.value);
        else
          total = total + parseInt(tbl.innerHTML);
      }
      htmlTotalPrice.innerHTML = total;
      for(let i = 1; i < table.rows.length; i++)
      {
        let tbl = table.rows[i].cells[9];
        if (tbl.children.length>0)
          sellTotal = sellTotal + parseInt(tbl.firstChild.value);
        else
          sellTotal = sellTotal + parseInt(tbl.innerHTML);
      }
      htmlDiscountPrice.innerHTML = sellTotal;
    }

    function alertCancelCreatedInvoice()
    {
      let text = "<b>Are you sure want to cancel this invoice</b>";
      Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: `Cancel Invoice`,
        denyButtonText: `No`,
        html: text
      }).then((result) => {
        if (result.isConfirmed) 
        {
          cancelCreatedInvoice();
        }
      });
    }

    function cancelCreatedInvoice()
    {
      let btnSetSeller = document.getElementById('btnSetSeller');
      let btnRemSeller = document.getElementById('btnRemSeller');
      let inputInvoiceNumber = document.getElementById('inputInvoiceNumber');
      let inputOpenModal = document.getElementById('inputOpenModal');
      let viewSellerName = document.getElementById('viewSellerName');
      let viewSellerAddress = document.getElementById('viewSellerAddress');
      let viewSellerContact = document.getElementById('viewSellerContact');
      let sellerProfileImage = document.getElementById('sellerProfileImage');
      let selectSeller = document.getElementById('selectSeller');
      let SellRecordTableBody = document.getElementById('SellRecordTableBody');
      let invoiceNumber = inputInvoiceNumber.value;
      btnRemSeller.classList.add('disabled');

      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"invoice/delete",
       data:{
        'invoiceNumber' : invoiceNumber
      },
      success:function(response)
      {
        
        if (!response.error)
        {
          makeToast('success',response.message);
            // location.reload();
            inputInvoiceNumber.value = '';
            viewSellerName.innerHTML = '';
            sellerProfileImage.src = 'src/img/user.png';
            viewSellerAddress.innerHTML = '';
            viewSellerContact.innerHTML = '';
            btnRemSeller.classList.remove('disabled');
            btnRemSeller.style.display = 'none';
            btnSetSeller.style.display = 'block';
            selectSeller.removeAttribute('disabled');
            inputOpenModal.setAttribute('disabled','disabled');
            SellRecordTableBody.innerHTML = '';
          }
          else
            makeToast('error',response.message);
        }
      });

    }

    function setSeller()
    {
      let selectSeller = document.getElementById('selectSeller');
      let viewSellerName = document.getElementById('viewSellerName');
      let viewSellerAddress = document.getElementById('viewSellerAddress');
      let viewSellerContact = document.getElementById('viewSellerContact');
      let sellerProfileImage = document.getElementById('sellerProfileImage');
      let inputOpenModal = document.getElementById('inputOpenModal');
      let btnSetSeller = document.getElementById('btnSetSeller');
      let btnRemSeller = document.getElementById('btnRemSeller');
      btnSetSeller.classList.add('disabled');
      if (selectSeller.value>0)
      {
        playSuccess();
        let imageUrl = selectSeller.options[selectSeller.selectedIndex].getAttribute('data-icon');
        let sellerAddress = selectSeller.options[selectSeller.selectedIndex].getAttribute('data-address');
        let sellerContactNumber = selectSeller.options[selectSeller.selectedIndex].getAttribute('data-contact');
        viewSellerName.innerHTML = selectSeller.options[selectSeller.selectedIndex].text;
        sellerProfileImage.src = imageUrl;
        viewSellerAddress.innerHTML = sellerAddress;
        viewSellerContact.innerHTML = sellerContactNumber;
        selectSeller.setAttribute('disabled','');
        btnSetSeller.classList.remove('disabled');
        btnSetSeller.style.display = 'none';
        btnRemSeller.style.display = 'block';
        $('select').select2({width: "100%"});
        addInvoice(selectSeller.value);
        inputOpenModal.removeAttribute('disabled');
      }
      else
      {
        Swal.fire('Please Select A Seller.');
        playError();
        btnSetSeller.classList.remove('disabled');
      }
    }

    function openModalAlert()
    {
      let inputOpenModal = document.getElementById('inputOpenModal');
      if (inputOpenModal.getAttribute('disabled')!=null)
      {
        console.log('alert can show');
      }
      else
      {
        console.log('don need tosh');
      }
    }

    function addInvoice(sellerId)
    {
      let inputInvoiceNumber = document.getElementById('inputInvoiceNumber');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"/invoice/add",
       data:{
        'sellerId':sellerId
      },
      success:function(response)
      {
        
        if (!response.error)
        {
          inputInvoiceNumber.value = response.invoice.invoiceNumber;
        }
        else
          makeToast('error',response.message);
      }
    });
    }

    function getSellers()
    {
      $.ajax({
        headers:{  
         'token':token
       },
       type:"get",
       url:BASE_URL+"sellers",
       success:function(response)
       {
        
        if (!response.error)
        {
          let sellers = response.sellers;
          let sellerImage;
          sellers.forEach(setCategory);
          function setCategory(item, index) {
            if (item.sellerImage!=null)
            {
              sellerImage = item.sellerImage;
            }
            else
            {
             sellerImage = 'src/img/user.png'; 
           }
           $('#selectSeller').select2().append($('<option value="'+item.sellerId+'" data-icon="'+sellerImage+'" data-address="'+item.sellerAddress+'" data-contact="'+item.sellerContactNumber+'">'+item.sellerName+'</option>'));
           $('select').select2({width: "100%"});
         }
       }
       else
       {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: response.message
        });
      }
    }
  });
    }

    function getBrands()
    {
      $('#selectBrand').attr('disabled','disabled');
      fetch(BASE_URL+"brands",{
        headers:{
          'token':token
        }
      })
      .then(response=> response.json())
      .then(response=>{
          if (!response.error)
        {
        $('#selectBrand').removeAttr('disabled');
          let brands = response.brands;
          brands.forEach(setCategory);
          function setCategory(item, index) {
            $('#selectBrand').select2().append($('<option value="'+item.brandId+'">'+item.brandName+'</option>'));
            $('select').select2({width: "100%"});

          }
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
        });
    }

    function getItems()
    {
      $('#selectItem').attr('disabled','disabled');
      fetch(BASE_URL+"items",{
        headers:{
          'token':token
        }
      })
      .then(response=> response.json())
      .then(response=>{
        if (!response.error)
        {
          $('#selectItem').removeAttr('disabled');
          let items = response.items;
          items.forEach(setCategory);
          function setCategory(item, index) {
            $('#selectItem').select2().append($('<option value="'+item.itemId+'">'+item.itemName+'</option>'));
            $('select').select2({width: "100%"});
          }
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
        });
    }

    function getSizes()
    {
      $('#selectSize').attr('disabled','disabled');
      fetch(BASE_URL+"sizes",{
        headers:{
          'token':token
        }
      })
      .then(response=> response.json())
      .then(response=>{
        if (!response.error)
        {
          $('#selectSize').removeAttr('disabled');
          let sizes = response.sizes;
          sizes.forEach(setCategory);
          function setCategory(item, index) {
            $('#selectSize').select2().append($('<option value="'+item.sizeId+'">'+item.sizeName+'</option>'));
            $('select').select2({width: "100%"});
          }
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
        });
    }

    function getCategories()
    {
      let select = document.getElementById('selectCategory');
      selectCategory.setAttribute('disabled','disabled');
      fetch(BASE_URL+"categories",{
        headers:{
            'token':token
        }
      })
      .then(response => response.json())
      .then(response=>{
        if (!response.error)
        {
      selectCategory.removeAttribute('disabled');

          let categories = response.categories;
          categories.forEach(setCategory);
          function setCategory(item, index) {
            $('#selectCategory').select2().append($('<option value="'+item.categoryId+'">'+item.categoryName+'</option>'));
            $('select').select2({width: "100%"});
          }
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
      });
    }

    function getLocations()
    {
      $('#selectLocation').attr('disabled','disabled');
      fetch(BASE_URL+"locations",{
        headers:{
          'token':token
        }
      })
      .then(response=> response.json())
      .then(response=>{
        $('#selectLocation').removeAttr('disabled');
if (!response.error)
        {
          let locations = response.locations;
          locations.forEach(setCategory);
          function setCategory(item, index) {
            $('#selectLocation').select2().append($('<option value="'+item.locationId+'">'+item.locationName+'</option>'));
            $('select').select2({width: "100%"});
          }
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
        });
    }

    let mProducts;

    function getProducts()
    {
      let select = document.getElementById('selectLocation');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"get",
       url:BASE_URL+"products",
       success:function(response)
       {
        
        if(!response.error)
        {
          products = response.products;
          $('#productTable').DataTable( {
            data: response
          } );
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
      }
    });
    }

    function sendItem(value)
    {

    }

    function alertUpdateProductNoticeCount()
    {
      let productNoticeCount = document.getElementById('productNoticeCount');
      if (productNoticeCount.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Product Notice Count"
        });
        return;
      }
      let text = "<b>Are you  sure want to set product notice count to  <h4 style='font-weight:bold; color:red'>"+productNoticeCount.value+"</h4> </b>";
      Swal.fire({
        icon: 'warning',
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: `Update`,
        denyButtonText: `Cancel`,
        html: text
      }).then((result) => {
        if (result.isConfirmed) 
        {
          updateProductNoticeCount(productNoticeCount);
        }
      });
    }

    function updateProductNoticeCount(productNoticeCount)
    {
      let btnUpdateProductNoticeCount = document.getElementById('btnUpdateProductNoticeCount');
      btnUpdateProductNoticeCount.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"product/notice/count/update",
       data: 
       {  
         'productNoticeCount' : productNoticeCount.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          playSuccess();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          productNoticeCount.value = '';
          btnUpdateProductNoticeCount.classList.remove('disabled');
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnUpdateProductNoticeCount.classList.remove('disabled');
        }
      }
    });
    }

    function updateFirebaseWebToken(webToken)
    {
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"firebaseToken/update/web",
       data: 
       {  
         'webToken' : webToken
       },
       success:function(response)
       {
        if (response.error)
        {
          playError();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
        }
      }
    });
    }

    function addSize()
    {
      let sizeName = document.getElementById('sizeName');
      let btnAddSize = document.getElementById('btnAddSize');
      if (sizeName.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Size Name"
        });
        return;
      }
      if (sizeName.value.length<4)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Size Name too short"
        });
        return;
      }
      btnAddSize.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"size/add",
       data: 
       {  
         'sizeName' : sizeName.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          playSuccess();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          sizeName.value = '';
          btnAddSize.classList.remove('disabled');
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnAddSize.classList.remove('disabled');
        }
      }
    });
    }

    function addAdmin()
    {
      let categoryName = document.getElementById('categoryName');
      let btnAddCategory = document.getElementById('btnAddCategory');
      if (categoryName.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Category Name"
        });
        return;
      }
      if (categoryName.value.length<4)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Category Name too short"
        });
        return;
      }
      btnAddCategory.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"admin/add",
       data: 
       {  
         'categoryName' : categoryName.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          playSuccess();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          categoryName.value = '';
          btnAddCategory.classList.remove('disabled');
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnAddCategory.classList.remove('disabled');
        }
      }
    });
    }

    $("form#formAddAdmin").submit(function(e) {
      e.preventDefault();    
      var formData = new FormData(this);
      let userPassword;
      if (formData.get("adminName")=='')
      {
        makeToast('error',"Enter Name");
        return;
      }
      if (formData.get("adminName").length<3)
      {
        makeToast('error',"Name too Short");
        return;
      }
      if (formData.get("adminName").length>30)
      {
        makeToast('error',"Name too Long");
        return;
      }
      if (formData.get("adminEmail")=='')
      {
        makeToast('error',"Enter Email");
        return;
      }
      if (formData.get("adminEmail")<10 || formData.get("adminEmail")>40)
      {
        makeToast('error',"Enter Valid Email");
        return;
      }
      if (formData.get("adminPassword")=='')
      {
        makeToast('error',"Enter Password");
        return;
      }
      if (formData.get("adminPassword").length<7)
      {
        makeToast('error',"Password too Short");
        return;
      }
      if (formData.get("adminPosition")=='' || formData.get("adminPosition")==null)
      {
        makeToast('error',"Select admin Position");
        return;
      }
      if (userPassword==null || userPassword=='') 
      {
        Swal.fire({
          title: 'Enter Your Current Passowrd',
          input: 'password',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Add Admin'
        })
        .then((result) => {
          if (result.isConfirmed) 
          {
            formData.append('currentAdminPassword',result.value);

            $.ajax({
              headers:{  
               'token':token
             },
             url: BASE_URL+"admin/add",
             type: 'POST',
             data: formData,
             success: function (response) {
              if (response.error)
                makeToast('error',response.message);
              else
                makeToast('success',response.message);
            },
            cache: false,
            contentType: false,
            processData: false
          });

          }
        });
      };
    });

    function addCategory()
    {
      let categoryName = document.getElementById('categoryName');
      let btnAddCategory = document.getElementById('btnAddCategory');
      if (categoryName.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Category Name"
        });
        return;
      }
      if (categoryName.value.length<3)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Category Name too short"
        });
        return;
      }
      btnAddCategory.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"category/add",
       data: 
       {  
         'categoryName' : categoryName.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          playSuccess();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          categoryName.value = '';
          btnAddCategory.classList.remove('disabled');
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnAddCategory.classList.remove('disabled');
        }
      }
    });
    }

    function addLocation()
    {
      let locationName = document.getElementById('locationName');
      let btnAddLocation = document.getElementById('btnAddLocation');
      if (locationName.value=='')
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Enter Location Name"
        });
        return;
      }
      if (locationName.value.length<2)
      {
        playWarning();
        Toast.fire({
          icon: 'error',
          title: "Location Name too short"
        });
        return;
      }
      btnAddLocation.classList.add('disabled');
      $.ajax({
        headers:{  
         'token':token
       },
       type:"post",
       url:BASE_URL+"location/add",
       data: 
       {  
         'locationName' : locationName.value
       },
       success:function(response)
       {
        if (!response.error)
        {
          playSuccess();
          Toast.fire({
            icon: 'success',
            title: response.message
          });
          locationName.value = '';
          btnAddLocation.classList.remove('disabled');
        }
        else
        {
          playWarning();
          Toast.fire({
            icon: 'error',
            title: response.message
          });
          btnAddLocation.classList.remove('disabled');
        }
      }
    });
    }
