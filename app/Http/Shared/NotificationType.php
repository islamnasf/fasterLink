<?php

namespace App\Http\Shared;

class NotificationType
{
    const general = 'general';

    //طلب انضمام لمتجر (User App)
    const join = 'join';
    //صرف مكافأة (User App)
    const reward = 'reward';
    //اكتمال حد الولاء (User App)
    const loyaltyComplete = 'loyalty_complete';
    //خصم نقاط من العميل (User App)
    const pointsDeduction = 'points_deduction';
    //اقتراب اكتمال حد الولاء ومتبقي اقل من %20 (User App)
    const loyaltyCloseTo = 'loyalty_close_to';
    //اضافة نقاط
    const addPoints = 'add_points';
    //صرف نقاط
    const pointsExchanged = 'points_exchanged';
    //مشاركة نقاط
    const pointsSharing = 'points_sharing';
    //الترحيب بانضمام متجر
    const WelcomeStore = 'welcome_store';
    //انتهاء صلاحية النقاط
    const expired = 'expired';

    //انشاء متجر (Store App)
    const createStore = 'create_store';
    //تفعيل متجر (Store App)
    const enableStore = 'enable_store';
    //تعطيل متجر (Store App)
    const disableStore = 'disable_store';

    //انشاء فاتورة من جهة المستخدم
    const userInvoice = 'user_invoice';
    //الموافقة على فاتورة واضافة نقاط
    const acceptInvoicePoints = 'accept_invoice_points';
    //الموافقة على فاتورة واضافة ولاء
    const acceptInvoiceLoyalty = 'accept_invoice_loyalty';
}
