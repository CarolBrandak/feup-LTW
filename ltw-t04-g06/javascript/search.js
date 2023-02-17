const searchRestaurant = document.querySelector('#searchrestaurant')
const searchRestaurant1 = document.querySelector('#searchrestaurant1')
const searchRestaurant2 = document.querySelector('#searchrestaurant2')
const searchItem = document.querySelector('#searchitem');
if (searchRestaurant) {
  searchforRestaurant(searchRestaurant);
}
if (searchRestaurant1){
  searchforRestaurant(searchRestaurant1);
}
if (searchRestaurant2){
  searchforRestaurant2(searchRestaurant2);
}


if (searchItem) {
  searchItem.addEventListener('input', async function() {

    const response = await fetch('../action/api.items.php?search=' + this.value)
    

    const items = await response.json()

    const section = document.querySelector('#itemssearch')
    section.innerHTML = ''
    const table = document.createElement('table');
    table.id="tables";
    table.innerHTML='<tr><th scope="col">#</th><th scope="col">Menu Item</th><th scope="col">Price</th><th scope="col">Category</th><th scope="col">Photo</th></tr>';
    let counter=0;
    
    for (const item of items) {
      if (this.value==""){
        break;
      }
      if (!item.active){
        continue;
      }
      const tr = document.createElement('tr');
      const td = document.createElement('td');
      const td2 = document.createElement('td');
      const td3 = document.createElement('td');
      const td4 = document.createElement('td');
      const td5 = document.createElement('td');
      td.scope='col';
      td2.scope='col';
      td3.scope='col';
      td4.scope='col';
      td5.scope='col';
      const link = document.createElement('a')
      link.href = 'menu.php?id=' + item.menu;
      link.textContent = item.name
      const img = document.createElement('img')
      img.src = '../itemPictures/' + item.photo;
      td.textContent = counter + 1;
      td2.appendChild(link);
      td3.textContent=item.price+"€";
      td4.textContent=item.category;
      td5.appendChild(img);
      tr.appendChild(td);
      tr.appendChild(td2);
      tr.appendChild(td3);
      tr.appendChild(td4);
      tr.appendChild(td5);
      if (counter==0){
        section.appendChild(table);
      }
      table.appendChild(tr);
      counter++;
    }
    
  })
} 

function searchforRestaurant(type){
  type.addEventListener('input', async function() {
    
    const response = await fetch('../action/api.restaurants.php?search=' + this.value)

    const restaurants = await response.json()

    const section = document.querySelector('#restaurants')
    section.innerHTML = ''

    for (const restaurant of restaurants) {
      if (this.value==""&&type.id=='searchrestaurant1'){
        break;
      }
      const article = document.createElement('article')
      const img = document.createElement('img')
      const br = document.createElement('br')
      img.src = '../restaurantPictures/' + restaurant.photo;
      const link = document.createElement('a')
      link.href = 'restaurant.php?id=' + restaurant.id
      link.textContent = restaurant.name
      article.appendChild(img)
      article.appendChild(br)
      article.appendChild(link)
      section.appendChild(article)
    }
  })
}
  function searchforRestaurant2(type){
    type.addEventListener('input', async function() {
      
      const response = await fetch('../action/api.restaurantsByItem.php?search=' + this.value);
  
      const restaurants = await response.json()
  
      const section = document.querySelector('#restaurants')
      section.innerHTML = ''
  
      for (const restaurant of restaurants) {
        if (this.value==""){
          break;
        }
        const article = document.createElement('article')
        const img = document.createElement('img')
        const br = document.createElement('br')
        img.src = '../restaurantPictures/' + restaurant.photo;
        const link = document.createElement('a')
        link.href = 'restaurant.php?id=' + restaurant.id
        link.textContent = restaurant.name
        article.appendChild(img)
        article.appendChild(br)
        article.appendChild(link)
        section.appendChild(article)
      }
    })
}
