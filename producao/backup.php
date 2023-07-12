<?php
/*
Template Name: Relatório de Pedidos
*/

// Arrays para armazenar os dados do relatório
$report_data = array();
$payment_data = array();

// Obtém os pedidos
$args = array(
    'post_type' => 'mydelivery-orders',
    'posts_per_page' => -1,
);

$orders = new WP_Query($args);

// Loop pelos pedidos
if ($orders->have_posts()) {
    while ($orders->have_posts()) {
        $orders->the_post();
        $postid = get_the_ID();
        $order_items = get_field('order_items');
        $payment_method = get_field('order_payment_method');
        $post_title = get_the_title();
        $total_order_value = get_field('order_total');
        $order_status = get_field('order_status');

        // Adiciona os dados ao array de pagamentos
        if ($order_status == "finished") {
            $payment_data[] = array(
                'payment_method' => $payment_method,
                'total_value_order' => $total_order_value,
                'order_id' => $post_title,
                'total_order' => 1
            );
        }

        // Loop pelos itens do pedido
        if ($order_items && $order_status == "finished") {
            foreach ($order_items as $item) {
                $product_name = $item['order_product'];
                $quantidade = $product_name[0];
                $product_price = 0; // Inicializa o preço como zero

                $product_name = preg_replace('/\d+\s+x\s+/', '', $product_name);
                $produto_args = array(
                    'post_type' => 'mydelivery-produtos',
                    'posts_per_page' => 1,
                    's' => $product_name,
                );

                $produto_query = new WP_Query($produto_args);

                if ($produto_query->have_posts()) {
                    $produto_query->the_post();
                    $product_price = get_field('product_price');
                    // Adicione o valor do preço ao total de vendas
                    $data['total_sales'] = $product_price;
                }

                // Restauro a consulta original
                wp_reset_postdata();

                // Adiciona os dados ao array de relatório
                $report_data[] = array(
                    'product_name' => $product_name,
                    'order_count' => $quantidade,
                    'total_sales' => $product_price,
                    'post_title' => $post_title,
                );
            }
        }
    }
    wp_reset_postdata();
}

// Criar um array para armazenar os produtos agrupados
$reduced_report_data = array();

// Percorrer o array $report_data
foreach ($report_data as $data) {
    $product_name = $data['product_name'];
    $order_count = $data['order_count'];
    // Verificar se o produto já existe no array $reduced_report_data
    if (array_key_exists($product_name, $reduced_report_data)) {
        // Produto já existe, somar o order_count existente com o novo order_count
        $reduced_report_data[$product_name]['order_count'] += $order_count;
    } else {
        // Produto não existe, adicionar ao array $reduced_report_data
        $reduced_report_data[$product_name] = $data;
    }

}

$reduced_report_payment = array();
foreach ($payment_data as $data) {

    $payment_form = $data['payment_method'];
    $order_total = $data['total_value_order'];
    $total_order_number = $data['total_order'];

    // Verificar se o produto já existe no array $reduced_report_data
    if (array_key_exists($payment_form, $reduced_report_payment)) {
        // Produto já existe, somar o order_count existente com o novo order_count
        $reduced_report_payment[$payment_form]['total_value'] += $order_total;
        $reduced_report_payment[$payment_form]['quantiti_orders'] += $total_order_number;
    } else {
        // Produto não existe, adicionar ao array $reduced_report_data
        $reduced_report_payment[$payment_form] = array(
            'payment_metod' => $payment_form,
            'total_value' => $order_total,
            'quantiti_orders' => $total_order_number,
        );

    }
}

foreach ($reduced_report_data as &$data) {
    $total_sales = $data['total_sales'] * $data['order_count'];
    $formatted_total_sales = number_format($total_sales, 2, '.', ''); // Formata o valor com duas casas decimais
    $data['total_sales'] = $formatted_total_sales;
}

// Ordenar o array $reduced_report_data por número de pedidos em ordem decrescente
usort($reduced_report_data, function ($a, $b) {
    return $b['order_count'] - $a['order_count'];
});

// Ordenar o array $reduced_report_payment por número de pedidos em ordem decrescente
usort($reduced_report_payment, function ($a, $b) {
    return $b['quantiti_orders'] - $a['quantiti_orders'];
});

$json_data_pedidos = json_encode($reduced_report_data, JSON_UNESCAPED_UNICODE);
$json_data_pagamentos = json_encode($reduced_report_payment, JSON_UNESCAPED_UNICODE);


?>















