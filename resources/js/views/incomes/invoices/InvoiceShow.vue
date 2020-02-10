<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">show </h4>
                        </div>
                        <div class="card-body mt-5">
                            <Stepper
                                :vertical="true"
                                :steppers="[
                                    { label:'Create Invoice',id:0},
                                    { label:'Send Invoice',id:1},
                                    { label:'steep 3',id:2}]"  >
                                <template v-slot:0>
                                    Status: Created on {{ invoice.invoice_date }}
                                </template>
                                <template v-slot:1>
                                    Status:
                                    <span v-if="invoice.status === 0">Not sent</span>
                                </template>
                                <template v-slot:2>
                                    asdasdasdas
                                </template>
                            </Stepper>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import CurrencyRequest from "../../../http/api/CurrencyRequest";
    import CustomerRequest from "../../../http/api/CustomerRequest";
    import InvoiceRequest from "../../../http/api/InvoiceRequest";
    import InvoiceCategoryRequest from "../../../http/api/InvoiceCategoryRequest";
    import ItemRequest from "../../../http/api/ItemRequest";
    import TaxRequest from "../../../http/api/TaxRequest";

    export default {
        name: "IncomesInvoiceShow",
        props: {
            edit: {
                default: false
            },
        },
        data: () => {
            return {
                invoice: {
                    items: [new Object],
                    currency: {},
                    invoice_date: '2018-06-01',
                    due_date: '2018-06-01',
                },
                form: {},
                items: [],
                categories: [],
                taxes: [],
                recurring: {
                    data: [
                        'No', 'Daily', 'Weekly', 'Monthly', 'Yearly', 'Custom'
                    ],
                    times: false
                },
                isLoading: false,
                customers: [],
                currencies: [],
                currencyDefault: null,
            }
        },
        mounted() {
            let self = this;
             InvoiceRequest.show(self.$route.params.id).then(data => {
                 let invoice = data.invoice;
                 invoice.items = data.invoice.invoice_items.map(function ($item) {
                     return {
                         item: $item.item,
                         quantity: $item.quantity,
                         taxes: $item.taxes
                     }
                 });
                 self.$set(self, 'invoice', invoice)
             })
        },
        methods: {
            update($event) {
                $event.preventDefault();
                let self = this;
                console.log()
                if (this.validate(self.invoice)) {
                    self.form.currency_id = self.invoice.currency.id;
                    self.form.customer_id = self.invoice.customer.id;
                    self.form.invoice_number = self.invoice.invoice_number;
                    self.form.order_number = self.invoice.order_number;
                    self.form.items = self.invoice.items.map(function (item) {
                        return {
                            item_id: item.item.id,
                            quantity: (item.quantity || 1),
                            tax: Array.isArray(item.taxes) ? (item.taxes.map(function (item) {
                                return item.id
                            })) : null
                        }
                    });
                    self.form.description = self.invoice.description;
                    self.form.category_id = self.invoice.category.id;
                    self.form.discount = self.invoice.discount;
                    self.form.invoice_date = this.$moment(self.invoice.invoice_date).format('MM/D/YYYY');
                    self.form.due_date = this.$moment(self.invoice.due_date).format('MM/D/YYYY');
                    if (self.edit)
                        InvoiceRequest.update(self.invoice.id, {
                            invoice: self.form
                        }).then(data => {
                            self.$router.push({name: 'incomes-invoices-index'});
                            self.$toastr.s(data.message);
                        });
                    else InvoiceRequest.create({
                        invoice: self.form
                    }).then(data => {
                        self.$router.push({name: 'incomes-invoices-index'});
                        self.$toastr.s(data.message);
                    });
                }

            },
            validate(invoice) {
                if (!invoice.currency) {
                    this.$toastr.e('A currency is required');
                    return false;
                }
                if (!invoice.customer) {
                    this.$toastr.e('A customer is required');
                    return false;
                }
                if (!invoice.invoice_number) {
                    this.$toastr.e('A invoice number is required');
                    return false;
                }
                if (!invoice.order_number) {
                    this.$toastr.e('A order number is required');
                    return false;
                }
                if (!invoice.items[0].item) {
                    this.$toastr.e('A item is required');
                    return false;
                }
                if (!invoice.description) {
                    this.$toastr.e('A description is required');
                    return false;
                }
                if (!invoice.category) {
                    this.$toastr.e('A category is required');
                    return false;
                }
                if (!invoice.invoice_date) {
                    this.$toastr.e('A invoice date is required');
                    return false;
                }
                if (!invoice.due_date) {
                    this.$toastr.e('A due date is required');
                    return false;
                }
                return true;
            },
            customerFind(query, loading) {
                let self = this;
                loading(true);
                CustomerRequest.search({
                    search: query
                }).then((data) => {
                    self.customers = data.customers;
                    loading(false);
                });
            },
            itemsFind(search, loading) {
                loading(true);
                ItemRequest.search({
                    search: search,
                }).then((data) => {
                    this.items = data.items;
                    loading(false);
                });
            },
            RecurringSelect(select) {
                let times = [
                    'Daily', 'Weekly', 'Monthly', 'Yearly'
                ];
                if (times.indexOf(select) >= 0) {
                    this.recurring.times = null;
                } else {
                    this.recurring.times = false;
                }
            },
            removeList(index) {
                if (this.invoice.items.length > 1) {
                    this.invoice.items.splice(index, 1)
                } else {
                    this.$toastr.w('last item')
                }
            },
            setSelectedItems(value) {
                let id = [];
                let items = this.invoice.items.filter(item => {
                    if (id.indexOf(item.item.id) === -1 && id.push(item.item.id)) {
                        return true;
                    }
                });
                this.$set(this.invoice, 'items', items);
            },
            setDiscount() {
                let self = this;
                this.$swal.fire({
                    title: 'Set Discount',
                    input: 'number',
                    showCancelButton: true,
                    confirmButtonText: 'Set',
                    showLoaderOnConfirm: true,
                    preConfirm: (discount) => {
                        self.$set(self.invoice, 'discount', discount);
                    },
                });

            }
        },
        computed: {
            subTotal() {
                let acc = this.invoice.items.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data, null, 'subtotal')
                }, 0);

                return `${(acc * this.invoice.currency.rate).toFixed(2)} ${this.invoice.currency.code}`
            },
            tax() {
                let acc = this.invoice.items.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data, null, 'tax', this.invoice.discount)
                }, 0);
                return `${(acc * this.invoice.currency.rate).toFixed(2)} ${this.invoice.currency.code}`
            },
            total() {
                let acc = this.invoice.items.reduce((acc, data) => {
                    return acc + this.$helpers.getSalePrice(data, null, 'total_tax', this.invoice.discount)
                }, 0);

                return `${(acc * this.invoice.currency.rate).toFixed(2)} ${this.invoice.currency.code}`
            }
        }
    }
</script>
