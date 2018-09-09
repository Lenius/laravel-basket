<template>
    <div>
        <form @submit.prevent="OnAdd" method="post">

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <p style="font-weight:bold;width:300px;font-size: 2.4rem;">{{TotalPrice | currency}}</p>
                </div>
            </div>



            <div class="row" style="margin-top:20px">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="quantity" placeholder="Antal" value="1" required v-model="quantity"/>
                        <span class="input-group-btn"><button class="btn btn-success" type="submit"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;&nbsp;Læg i kurv</button></span>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top:20px">
                <div v-for="(item, index) in options" class="col-md-4">
                    <div class="form-group" v-if="item.type === 'dropdown'">
                        <label v-if="item.label">{{item.label}}</label>
                        <label v-else>{{item.name}}</label>
                        <select class="form-control" v-model="item.selected" :required="!!item.required">
                            <option value="">Vælg</option>
                            <option v-for="option in item.items" v-bind:value="option">
                                {{ option.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    Vue.filter('currency', function (value) {
        return parseFloat(value*1.25).toFixed(2) + ' DKK';
    })

    export default {

        mounted() {
            console.log('Component Product mounted.');
        },
        props: ['src'],
        watch: {
            // whenever options changes, this function will run
            options: {
                handler(val){
                    let price = parseFloat(this.product.price);

                    this.options.forEach(function(el,idx) {
                        if (typeof el.selected !== "undefined" && el.selected != null){
                            if(el.selected.price != null){
                                price += parseFloat(el.selected.price);
                            }
                        }

                    });
                    this.TotalPrice = price;
                },
                deep: true
            }
        },

        computed: {
            // a computed getter
            TotalPrice: {
                get: function () {
                    return parseFloat(this.price);
                },
                // setter
                set: function (newValue) {
                    this.price = newValue;
                }
            },
            item:function(){
                return{
                    options: this.options,
                    id : this.product.id,
                    quantity : this.quantity
                }
            }

        },

        data() {
            return {
                quantity : 1,
                price : 0,
                product:{},
                options: []
            }
        },

        created(){
            this.product = JSON.parse(this.src);
            this.options = this.product.options;
            this.TotalPrice = this.product.price;
        },

        methods: {
            OnAdd: function () {
                axios.post('/basket/add',this.item)
                    .then(response => {
                        document.location = '/basket';
                    }).catch(function (error) {
                    
                    alert(error.response.data);

                });
            },
        }
    }
</script>
