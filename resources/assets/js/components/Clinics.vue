<template>
    <section>
        <div class="level">
            <p class="level-left is-size-7" v-if="clinics.length">
                <span class="m-r-5">Resultados por página:</span>
                <b-radio v-model="perPage" size="is-small" native-value="20" @input="updatePagination">
                    20
                </b-radio>
                <b-radio v-model="perPage" size="is-small" native-value="50" @input="updatePagination">
                    50
                </b-radio>
                <b-radio v-model="perPage" size="is-small" native-value="100" @input="updatePagination">
                    100
                </b-radio>
                <b-radio v-if="clinics.length <= 200" v-model="perPage" size="is-small" native-value="0" @input="updatePagination">
                    Todas las facturas
                </b-radio>
            </p>

            <p v-if="clinics.length" class="level-right has-text-weight-light is-size-7 p-r-10">
                <span class="has-text-weight-semibold m-r-5">Total:</span> {{clinics.length}} {{clinics.length == 1 ? 'clínica' : 'clínicas'}}
            </p>
        </div>

        <b-table
            :data="clinics"
            :loading="loading"

			striped
            hoverable
            narrowed
            :mobile-cards="true"

            :total="total"
            :per-page="perPage"
            :paginated="paginated"
            @page-change="onPageChange"

            backend-sorting
            :default-sort-direction="searchData.defaultSortOrder"
            :default-sort="[searchData.sortField, searchData.sortOrder]"
            @sort="onSort">

            <template slot-scope="props">

                <b-table-column field="name" label="Clínica" sortable>
                     {{ props.row.name }}
                </b-table-column>

                <b-table-column field="facturas" label="Facturas" sortable>
                    {{ props.row.invoices.length }}
                </b-table-column>


    				<b-table-column label="Acciones" width="290">
    					<a :href="'/app/clinics/'+props.row.id" class="button is-small m-r-5">
    						<span class="icon m-r-5"><i class="mdi mdi-eye"></i></span>Ver
    					</a>
    					<a :href="'/app/clinics/'+props.row.id+'/edit'" class="button is-small m-r-5 is-info">
    						<span class="icon m-r-5"><i class="mdi mdi-pencil"></i></span>Editar
    					</a>
    					<a :href="'/app/clinics/'+props.row.id+'/invoices'" class="button is-small m-r-5 is-link">
    						<span class="icon m-r-5"><i class="fa fa-file-pdf-o"></i></span>Facturas
    					</a>
    					<a href="" class="delete-invoice-button button is-small is-danger" v-on:click.prevent="deleteClinic(props.row)">
    						<span class="icon"><i class="mdi mdi-delete"></i></span>
    					</a>
    				</b-table-column>
            </template>

            <template v-if="!loading" slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                icon="emoticon-sad"
                                size="is-large">
                            </b-icon>
                        </p>
                        <p>No hay resultados.</p>
                    </div>
                </section>
            </template>
        </b-table>
    </section>
</template>

<script>
    export default {
        props: ['showUnpaid', 'clinicId'],
        data() {
            return {
                clinics: [],
                source: '/app/clinicsapi',
                loading: true,
                paginated: true,
                perPage: 20,
                page: 1,
                total: 0,
                searchData: {
                    defaultSortOrder: 'asc',
                    sortField: 'name',
                    sortOrder: 'asc',
                    clinicName: '',
                },
            }
        },
        methods: {
             updatePagination() {
                if(this.perPage == 0){
                    this.paginated = false;
                } else {
                    if(this.perPage >= this.total){
                      this.paginated = false;
                    } else {
                      this.paginated = true;
                    }
                }
            },
            getClinics() {
                axios.get('/app/clinicsapi', {params: this.searchData})
                            .then(response => {
                              // console.info(response.data); return;
                              // JSON responses are automatically parsed.
                              this.loading = true;
                              this.clinics = response.data.clinics;
                              this.total = this.clinics.length;
                              this.loading = false;
                              this.updatePagination();
                            })
                            .catch(e => {
                              this.errors.push(e)
                              console.info(this.errors)
                            });
            },
            deleteClinic(clinic) {
            		swal("¿Seguro que quieres eliminar la clínica "+clinic.name+"?", {
							      dangerMode: true,
							      buttons: ['Cancelar', "Eliminar"],
						    }).then((willDelete) => {
							      if (willDelete) {
					            	axios.delete('/app/clinicsapi/'+clinic.id)
                        .then(response => {
					            		this.$toast.open({
					                    message: response.data.message,
					                    position: 'is-bottom-right',
					                    duration: 5000,
                                        queue: true
				                	})
					            		this.getClinics()
					            	})
										    .catch(e => {
										      this.errors.push(e)
										      console.info(this.errors)
										    })
							      }
						    });
            },
            onPageChange(page) {
                this.page = page
                this.getClinics()
            },
            onSort(field, order) {
                this.searchData.sortField = field
                this.searchData.sortOrder = order
                this.getClinics()
            },
        },
        filters: {
            /**
             * Filter to truncate string, accepts a length parameter
             */
            truncate(value, length) {
                return value.length > length
                    ? value.substr(0, length) + '...'
                    : value
            }
        },
        mounted() {
            this.getClinics();
        }
    }
</script>
