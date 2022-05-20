<template>
          
        <div class="container">
          <div class="row ">
             <div class="col-md-12 mt-2">
             <Datepicker v-model="date" ></Datepicker>
             <input type="text" v-model="keyword" />
             <button @click="search">  Search</button>
            </div>
            </div>
          <div class="row">

                <div class="col-md-4 mt-2" 
                    v-for="product in products" >
            
                
                <div class="card">
                                    <div class="card-body">
                                        <div class="card-img-actions">
                                            
                                        <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">
                                              
                                           
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2">
                                                <a href="#" class="text-default mb-2" data-abc="true">{{ product.name}}</a>
                                            </h6>

                                            <!-- <a href="#" class="text-muted" data-abc="true">Laptops & Notebooks</a> -->
                                        </div>

                                        <h3 class="mb-0 font-weight-semibold">$250.99</h3>

                                        <div>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                        </div>

                                        <!-- <div class="text-muted mb-3">34 reviews</div> -->

                                        <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>

                                        
                                    </div>
                                </div>


                            
                             
           </div> 


           <nav aria-label="Page navigation example" v-if="isPagination">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" @click=clickPagination(previousPage)>
                Previous</a></li>
                <li class="page-item"><a class="page-link"  @click=clickPagination(currentPage)>
                {{ currentPage }}</a></li>
                <li class="page-item"><a class="page-link"  @click=clickPagination(nextPage)>Next</a></li>
              </ul>
            </nav>

        </div>
    </div>

 </div>

</template>

<script>
    import moment from 'moment'
    import Datepicker from 'vuejs-datepicker'
 
    export default {
         components: {
            Datepicker
        },

        data() {
            return {
                isProducts : false,
                isPagination : false,
                currentPage : 1,
                nextPage : 0,
                previousPage : 0,
                products : [],
                date : '',
                keyword : ''
            };
        },
        mounted() {

            this.loadProducts();

        },
        
        methods: {
            async loadProducts(){

              var _vm = this

              let searchString = '';

              if(this.date){
                  // this.date - moment(this.date, 'YYYY-MM-DD').format(format)
                searchString = '&date='+this.date.toLocaleDateString()
              }

              if(this.keyword){
                searchString = '&keyword='+this.keyword
              }
            
              await axios.get('products?page='+this.currentPage+searchString)
                .then(function (response) {
                       let res = response.data
                        _vm.products = res.data
                        _vm.isProducts = true
                      
                        if(res.last_page >0){
                            _vm.isPagination = true
                            _vm.currentPage = res.current_page
                            if(res.current_page < res.last_page){
                                 _vm.nextPage = (res.current_page < res.last_page ) ? res.current_page + 1 : res.last_page; 
                                 _vm.previousPage = (res.current_page > 1) ? res.current_page - 1 : 1; 
                            }
                        }

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            clickPagination(page){
                     this.currentPage = page
                     this.loadProducts()
            },
            search(){
                this.currentPage = 1;
                this.loadProducts()
            }
        }

    }
</script>
