<create-proforma
     :proforma="{
            'id' : '{{ empty($proforma->id) ? '' : $proforma->id }}',
            'client_id' : '{{ empty($proforma->negotiationProformas->negotiation->client_id) ? '' : $proforma->negotiationProformas->negotiation->client_id }}',
            'client_name' : '{{ empty($proforma->negotiationProformas->negotiation->client->name) ? '' : $proforma->negotiationProformas->negotiation->client->name }}',
            'seller_id' : '{{ empty($proforma->negotiationProformas->negotiation->client->seller->id) ? '' : $proforma->negotiationProformas->negotiation->client->seller->id }}',
            'negotiation_id' : '{{ empty($proforma->negotiationProformas->negotiation->id) ? '' : $proforma->negotiationProformas->negotiation->id }}',
            'negotiation_proforma_id' : '{{ empty($proforma->negotiationProformas->id) ? '' : $proforma->negotiationProformas->id }}',
            'factor' : '{{ empty($proforma->factor) ? 0 : $proforma->factor }}',
            'price_select' : '{{ empty($proforma->type_price) ? 0 : $proforma->type_price }}',
            'total_items' : '{{ empty($proforma->total_items) ? 0 : $proforma->total_items }}',
            'provisional' : '{{ empty($proforma->provisional) ? 0 : 1  }}',
            }"
></create-proforma>              