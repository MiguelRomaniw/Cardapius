<?php
/*
Template Name: Relatório de Pedidos
*/

// Obtém os pedidos
$args = array(
    'post_type' => 'mydelivery-orders',
    'posts_per_page' => -1,
);

$orders = new WP_Query($args);

// Arrays para armazenar os dados do relatório
$report_data = array();
$payment_data = array();

// Loop pelos pedidos
if ($orders->have_posts()) {
    while ($orders->have_posts()) {
        $orders->the_post();
        $postid = get_the_ID();
        $order_items = get_field('order_items');
        $payment_method = get_post_meta($postid, 'order_payment_method', true);

        // Loop pelos itens do pedido
        if ($order_items) {
            foreach ($order_items as $item) {
                $product_name = $item['order_product'];
                $product_price = $item['order_item_price'];

                // Verifica se o produto já existe no relatório
                if (isset($report_data[$product_name])) {
                    // Incrementa o número de pedidos para o produto existente
                    $report_data[$product_name]['order_count']++;
                    // Calcula o valor total de vendas para o produto existente
                    $report_data[$product_name]['total_sales'] += $product_price;
                } else {
                    // Adiciona um novo produto ao relatório
                    $report_data[$product_name] = array(
                        'product_name' => $product_name,
                        'order_count' => 1,
                        'total_sales' => $product_price,
                    );
                }
            }
        }

        // Verifica se o método de pagamento já existe no relatório de pagamentos
        if (isset($payment_data[$payment_method])) {
            // Incrementa o número de pedidos para o método de pagamento existente
            $payment_data[$payment_method]['order_count']++;
            // Calcula o valor total de pedidos para o método de pagamento existente
            $payment_data[$payment_method]['total_sales'] += $product_price;
        } else {
            // Adiciona um novo método de pagamento ao relatório de pagamentos
            $payment_data[$payment_method] = array(
                'payment_method' => $payment_method,
                'order_count' => 1,
                'total_sales' => $product_price,
            );
        }
    }
    wp_reset_postdata();
}

// Ordena os produtos pelo número de pedidos em ordem decrescente
uasort($report_data, function ($a, $b) {
    return $b['order_count'] - $a['order_count'];
});

// Ordena os métodos de pagamento pelo número de pedidos em ordem decrescente
uasort($payment_data, function ($a, $b) {
    return $b['order_count'] - $a['order_count'];
});

// Agora você pode utilizar as variáveis $report_data e $payment_data
// para obter os dados do relatório e realizar as operações necessárias.
// A parte de renderização do conteúdo foi removida.

// Exemplo de uso:
foreach ($report_data as $data) {
    $product_name = $data['product_name'];
    $order_count = $data['order_count'];
    $total_sales = $data['total_sales'];

    // Faça algo com os dados do produto
    // ...
}

foreach ($payment_data as $data) {
