<template>
    <section>
        <p v-show="showUnpaid != 1" class="invoice-show-unpaid-switcher">
            <b-switch
                v-model="searchData.showOnlyUnpaid"
                size="is-small"
                type="is-success"
                @input="changeShowUnpaid">
                Mostrar sólo facturas pendientes
            </b-switch>
        </p>

        <!-- <p v-show="!clinicId" class="invoice-show-clinic">
            <b-field>
                <b-autocomplete
                    :keep-first="true"
                    :open-on-focus="true"
                    :data="clinics"
                    placeholder="Buscar facturas por clínica"
                    field="name"
                    size="is-small"
                    @select="changeClinicScope">
                    <template slot="props">Clinica</template>
                    <template slot="empty">No se han encontrado resultados.</template>
                </b-autocomplete>
            </b-field>
        </p> -->

        <p class="invoice-date-range-selector">
            <b-field class="date-search-type-field">
                <b-select
                    v-model="searchData.dateType"
                    size="is-small"
                    placeholder="Tipo de fecha"
                    @input="cleanSearchDates">
                    <option v-show="searchData.showOnlyUnpaid == '0'" value="payment_date">Fecha de pago</option>
                    <option value="invoice_date">Fecha expedición</option>
                </b-select>
            </b-field>
            <template v-if="searchData.dateType">
                <span>entre</span>
                <b-field class="date-picker-field">
                    <b-datepicker
                        v-model="searchData.datePicker1"
                        placeholder="Escribe o selecciona fecha"
                        icon="calendar-today"
                        size="is-small"
                        :first-day-of-week="1"
                        :month-names="$parent.monthNames"
                        :day-names="$parent.dayNames"
                        :readonly="false"
                        @input="searchByDate">

                        <button class="button is-danger is-small"
                            @click="searchData.datePicker1 = null">
                            <b-icon size="is-small" icon="close"></b-icon>
                            <span>Limpiar</span>
                        </button>
                    </b-datepicker>
                </b-field>
                <span>y</span>
                <b-field class="date-picker-field">
                    <b-datepicker
                        v-model="searchData.datePicker2"
                        placeholder="Escribe o selecciona fecha"
                        icon="calendar-today"
                        size="is-small"
                        :first-day-of-week="1"
                        :month-names="$parent.monthNames"
                        :day-names="$parent.dayNames"
                        :readonly="false"
                        @input="searchByDate">

                        <button class="button is-primary is-small"
                            @click="searchData.datePicker2 = new Date()">
                            <b-icon size="is-small" icon="calendar-today"></b-icon>
                            <span>Hoy</span>
                        </button>

                        <button class="button is-danger is-small"
                            @click="searchData.datePicker2 = null">
                            <b-icon size="is-small" icon="close"></b-icon>
                            <span>Limpiar</span>
                        </button>
                    </b-datepicker>
                </b-field>
                <button class="button is-info is-small search-invoices-button" @click.prevent="cancelSearchByDate">Limpiar</button>
            </template>
        </p>

        <div class="level">
            <p class="level-left is-size-7" v-if="invoices.length">
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
                <b-radio v-if="invoices.length <= 200" v-model="perPage" size="is-small" native-value="0" @input="updatePagination">
                    Todas las facturas
                </b-radio>
            </p>

            <p v-if="invoices.length" class="level-right has-text-weight-light is-size-7 p-r-10">
                <span class="has-text-weight-semibold m-r-5">Total:</span> {{invoices.length}} {{invoices.length == 1 ? 'factura' : 'facturas'}}
                <!-- <b-taglist attached class="has-text-right">
                    <b-tag type="is-dark">Mostrando</b-tag>
                    <b-tag type="is-success">{{invoices.length}} facturas</b-tag>
                </b-taglist> -->
            </p>
        </div>

        <b-table
            :data="invoices"
            :loading="loading"

            striped
            hoverable
            narrowed
            :mobile-cards="true"

            :paginated="paginated"
            :total="total"
            :per-page="perPage"
            @page-change="onPageChange"

            backend-sorting
            :default-sort-direction="searchData.defaultSortOrder"
            :default-sort="[searchData.sortField, searchData.sortOrder]"
            @sort="onSort">

            <template slot-scope="props">

                <b-table-column field="invoice_no" label="Nº factura" sortable>
                     {{ props.row.invoice_no }}
                </b-table-column>

                <b-table-column field="invoice_date" label="Fecha expedición" sortable>
                    {{ dateForHumans(props.row.invoice_date) }}
                </b-table-column>

                <b-table-column field="total" label="Total" sortable>
                    {{ numberFormat(props.row.total, 2, ',', '.', '', '€') }}
                </b-table-column>

                <b-table-column field="payment_date" label="Pago" sortable>
                    <b-tooltip v-if="props.row.payment_date" label="Haz click para marcar esta factura como pendiente." position="is-top" size="is-large" type="is-dark" multilined>
                        <span class="tag is-small is-rounded"
                                    :class="isPaid(props.row.payment_date)"
                                    @click="updatePaid(props.row)">
                            {{ dateForHumans(props.row.payment_date) }}
                        </span>
                    </b-tooltip>

                    <b-tooltip v-else label="Haz click para marcar esta factura como pagada." position="is-top" size="is-large" type="is-dark" multilined>
                        <span class="tag is-small is-rounded"
                                    :class="isPaid(props.row.payment_date)"
                                    @click="updatePaid(props.row)">
                            Pendiente
                        </span>
                    </b-tooltip>
                </b-table-column>


                <b-table-column label="Acciones" width="260">
                    <a :href="'/app/invoices/'+props.row.invoice_no" class="button is-small m-r-5">
                        <span class="icon m-r-5"><i class="mdi mdi-eye"></i></span>Ver
                    </a>
                    <a :href="'/app/invoices/'+props.row.invoice_no+'/edit'" class="button is-small m-r-5 is-info">
                        <span class="icon m-r-5"><i class="mdi mdi-pencil"></i></span>Editar
                    </a>
                    <a :href="'/app/invoices/'+props.row.invoice_no+'/pdf/show'" class="show-pdf-button button is-small m-r-5 is-link">
                        <span class="icon m-r-5"><i class="fa fa-file-pdf-o"></i></span>PDF
                    </a>
                    <a href="" class="delete-invoice-button button is-small is-danger" v-on:click.prevent="deleteInvoice(props.row)">
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
                invoices: [],
                clinics: [],
                clinicNameScope: '',
                total: 0,
                loading: true,
                paginated: true,
                perPage: 20,
                page: 1,
                searchData: {
                    sortField: 'invoice_no',
                    sortOrder: 'desc',
                    defaultSortOrder: 'desc',
                    clinicId: null,
                    showOnlyUnpaid: false,
                    dateType: null,
                    datePicker1: null,
                    datePicker2: null
                }
            }
        },
        methods: {
            changeShowUnpaid(){
                console.info(this.searchData.showOnlyUnpaid, this.searchData.dateType);
                if(this.searchData.showOnlyUnpaid == true && this.searchData.dateType == 'payment_date'){
                    this.cancelSearchByDate();
                }
                this.getInvoices();
            },
            updatePagination() {
                this.loading = true;
                if(this.perPage == 0){
                    this.paginated = false;
                } else {
                    if(this.perPage >= this.total){
                      this.paginated = false;
                    } else {
                      this.paginated = true;
                    }
                }
                this.loading = false;
            },
            getInvoices() {
                // $('.search-invoices-button').addClass('is-loading');
                this.loading = true
                axios.get('/app/invoicesapi', {params: this.searchData})
                            .then(response => {
                                // console.info(response); return;
                                // JSON responses are automatically parsed.
                                this.invoices = response.data.items;
                                this.total = this.invoices.length;
                                this.loading = false;
                                this.updatePagination();
                                $('.search-invoices-button').removeClass('is-loading');
                            })
                            .catch(e => {
                              this.errors.push(e)
                              console.info(this.errors)
                            })
            },
            getClinics() {
                axios.get(`/app/clinicsapi?name=${this.clinicNameScope}`)
                            .then(response => {
                              // console.info(response); return;
                              // JSON responses are automatically parsed.
                              this.clinics = response.data.clinics
                            })
                            .catch(e => {
                              this.errors.push(e)
                              console.info(this.errors)
                            });
            },
            deleteInvoice(invoice) {
                    swal("¿Seguro que quieres eliminar la factura "+invoice.invoice_no+"?", {
                                  dangerMode: true,
                                  buttons: ['Cancelar', "Eliminar"],
                            }).then((willDelete) => {
                                  if (willDelete) {
                                    axios.delete('/app/invoicesapi/'+invoice.id).then(response => {
                                        this.$toast.open({
                                        message: response.data.message,
                                        position: 'is-bottom-right',
                                        duration: 5000,
                                        queue: true
                                    })
                                        this.getInvoices()
                                    })
                                            .catch(e => {
                                              this.errors.push(e)
                                              console.info(this.errors)
                                            })
                                  }
                            });
            },
            /*
             * Update invoice state (paid / unpaid)
             */
            updatePaid(invoice) {
                    var paid = invoice.payment_date !== null ? true : false;
                    var url = '/app/invoicesapi/' + invoice.id + '?paid='
                    url += paid ? 'paid' : 'unpaid';
                    var message = "¿Seguro que quieres marcar la factura "+invoice.invoice_no+" como ";
                    message += paid ? 'pendiente?' : 'pagada?';
                    swal(message, {
                                  dangerMode: true,
                                  buttons: ['No', "Sí"],
                            })
                            .then((willUpdate) => {
                                  if (willUpdate) {
                                    axios.put(url).then(response => {
                                        this.$toast.open({
                                        message: response.data.message,
                                        position: 'is-bottom-right',
                                        duration: 5000
                                    })
                                        this.getInvoices()
                                    })
                                            .catch(e => {
                                              this.errors.push(e)
                                              console.info(this.errors)
                                            })
                                  }
                            });
            },
            /*
             * Handle page-change event
             */
            onPageChange(page) {
                this.page = page;
                this.getInvoices();
            },
            /*
             * Handle sort event
             */
            onSort(field, order) {
                this.searchData.sortField = field;
                this.searchData.sortOrder = order;
                this.getInvoices();
            },
            /*
             * Type style in relation to the value
             */
            isPaid(value) {
                if (value !== null) {
                    return 'is-success'
                } else {
                    return 'is-danger'
                }
            },
            searchByDate() {
                if(this.searchData.dateType && this.searchData.datePicker1 && this.searchData.datePicker2){
                    this.getInvoices();
                }
            },
            cancelSearchByDate() {
                let dt = this.searchData.dateType;
                let dp1 = this.searchData.datePicker1;
                let dp2 = this.searchData.datePicker2;

                this.searchData.dateType = null;
                this.searchData.datePicker1 = null;
                this.searchData.datePicker2 = null;

                if(dt !== null && dp1 !== null && dp2 !== null){
                    this.getInvoices();
                }
            },
            cleanSearchDates() {
                let dp1 = this.searchData.datePicker1;
                let dp2 = this.searchData.datePicker2;

                this.searchData.datePicker1 = null;
                this.searchData.datePicker2 = null;

                if(dp1 !== null && dp2 !== null){
                    this.getInvoices();
                }
            },
            /*
             * Number Formatting function
             */
            numberFormat(number, decimals, dec_point, thousands_sep, prepend, append) {
                // Strip all characters but numerical ones.
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return prepend+s.join(dec)+append;
            },
            /*
             * Get timestamp date and outputs 1 de enero de 2018
             */
            dateForHumans(date){
                var objDate = new Date(date);
                return objDate.toLocaleString("es", { day: "numeric" }) + ' de ' +
                       objDate.toLocaleString("es", { month: "long"  }) + ' de ' +
                       objDate.toLocaleString("es", { year: "numeric"});
            },
            convertDate(date){
                var objDate = new Date(date);
                return objDate.toLocaleString("es", { day: "numeric" }) + '-' +
                       objDate.toLocaleString("es", { month: "numeric"  }) + '-' +
                       objDate.toLocaleString("es", { year: "numeric"});
            }
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
            // this.prefix = this.showUnpaid == '1' ? '' : 'invoices/';
            this.searchData.showOnlyUnpaid = this.showUnpaid == '1' ? true : false;
            this.searchData.clinicId = this.clinicId;
            this.getInvoices();
            // this.getClinics();
        }
    }
</script>
