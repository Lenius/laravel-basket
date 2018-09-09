<template>
    <div>
        <form @submit.prevent="onSubmitOption" method="post">
            <div v-if="example" class="row" style="margin-top:20px">

                <div v-for="(item, index) in options" class="col-md-4">
                    <div class="form-group" v-if="item.type === 'dropdown'">
                        <label v-if="item.label">{{item.label}}</label>
                        <label v-else>{{item.name}}</label>
                        <select class="form-control">
                            <option value="">Vælg</option>
                            <option v-for="option in item.items" v-bind:value="option">
                                {{ option.name }} Pris {{ option.price }}
                            </option>
                        </select>
                    </div>
                </div>


            </div>
            <div class="row" style="margin-top:20px">
                <div class="col-md-12">
                    <h3>Options admin</h3>
                    <a v-on:click.stop="AddOption" class="btn">Ny</a>
                    <table v-for="(item, index) in options" style="margin-bottom:10px" class="table table-bordered">
                        <thead>
                        <tr>
                            <th >
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Name</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Color/Size" v-model="item.name" aria-label="Navn" aria-describedby="basic-addon1" required>
                                </div>

                            </th>
                            <th >
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Label</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Color/Size" v-model="item.label" aria-label="Navn" aria-describedby="basic-addon1">
                                </div>

                            </th>
                            <th >
                                <select class="form-control input-sm">
                                    <option value="dropdown">dropdown</option>
                                    <option value="radio">radio</option>
                                    <option value="checklist">checklist</option>
                                </select>
                            </th>
                            <th >
                                <div class="checkbox">
                                    <label><input type="checkbox" v-model="item.required"> Påkrævet</label>
                                </div>
                            </th>
                            <th class="text-center"><a v-on:click.stop="CopyOption(item)" ><i class="far fa-copy"></i></a></th>
                            <th class="text-center"><a v-on:click.stop="RemoveOption(item)" title="Slet variant"><i class="far fa-trash-alt"></i></a></th>
                            <th class="text-center"><a v-on:click.stop="AddItem(item)" title="Tilføj variant"><i class="fas fa-plus"></i></a></th>
                        </tr>
                        </thead>
                        <draggable v-model="item.items" :element="'tbody'">
                            <tr v-for="option in item.items">
                                <td>

                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Number</span>
                                        </div>
                                        <input type="text" class="form-control" v-model="option.number" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>

                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Name</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="" v-model="option.name" aria-label="Navn" aria-describedby="basic-addon1" required>
                                    </div>

                                </td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Weight</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="+- Vægt" v-model="option.weight" aria-label="Navn" aria-describedby="basic-addon1">
                                    </div>



                                </td>
                                <td>

                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Price</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="+- Price" v-model="option.price" aria-label="Navn" aria-describedby="basic-addon1" v-bind:title="'Pris : ' + (parseFloat(option.price) + parseFloat(product.price)).toFixed(2)" @keyup="PriceHelper(option, $event)">
                                    </div>


                                </td>
                                <td class="text-center"><a v-on:click.stop="CopyItem(item.items,option)" title="Kopier element"><i class="far fa-copy"></i></a></td>
                                <td class="text-center"><a v-on:click.stop="RemoveItem(item,option)" title="Fjern element"><i class="far fa-trash-alt"></i></a></td>
                                <td class="text-center"><i style="cursor:move" class="fas fa-arrows" v-if="item.items.length>1"></i></td>
                            </tr>
                        </draggable>

                    </table>
                </div>
            </div>
            <button type="submit">Gem</button> <input type="checkbox" id="checkbox" v-model="example">
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import draggable from 'vuedraggable';

    //https://github.com/SortableJS/Vue.Draggable

    export default {
        components: {
            draggable
        },
        props: ['src'],
        computed:{
            items:function(){
                return{
                    options: this.options,
                    id : this.product.id
                }
            }
        },
        mounted() {
            console.log('Component Admin mounted.');
        },
        data() {
            return {
                example : false,
                price : 0,
                option : {'name':'','type':'dropdown','label': '', 'required':false,'selected':'','items':[]},
                item : {'number':'','name':'','price':'','weight' : ''},
                product : {},
                options: []
            }
        },

        created(){
            this.product = JSON.parse(this.src);
            this.options = this.product.options;
        },
        methods: {
            PriceHelper(item,event) {

                switch(event.which) {
                    case 37: // left
                        item.price = ((item.price*1) -1).toFixed(2);
                        break;

                    case 38: // up
                        item.price = (item.price * 1.25).toFixed(2);
                        break;

                    case 39: // right
                        item.price = ((item.price*1) + 1).toFixed(2);
                        break;

                    case 40: // down
                        item.price= (item.price * 0.8).toFixed(2);
                        break;

                    default: return; // exit this handler for other keys
                }

            },
            AddOption: function() {
                this.options.push(JSON.parse(JSON.stringify(this.option)));
            },
            CopyOption: function(option) {
                this.options.push(JSON.parse(JSON.stringify(option)));
            },
            RemoveOption: function(option) {
                this.options.splice(this.options.indexOf(option),1);
            },
            AddItem: function(option) {
                option.items.push(JSON.parse(JSON.stringify(this.item)));
            },
            RemoveItem: function(item,option) {
                item.items.splice(item.items.indexOf(option),1);
            },
            CopyItem: function(item,option) {
                item.push(JSON.parse(JSON.stringify(option)));
            },
            refresh: function () {
                axios.get('/basket/calc_fragt')
                    .then(response => {

                    })
            },
            onSubmitOption: function () {
                var outer = this;
                //this.errors.clear();
                axios['post']('/product/store', this.items).then(function (response) {
                    //document.location = '/?tak=true';
                    alert('Gemt');
                }).catch(function (error) {
                    alert(error.response.data);
                    //outer.errors.record(error.response.data.errors);
                });
            }
        }
    }
</script>
