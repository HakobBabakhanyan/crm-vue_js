import Api from './Api';

class InvoiceCategoryRequest extends Api {
    static prefix(){ return  '/api/invoices/categories'};
}

export default InvoiceCategoryRequest;
