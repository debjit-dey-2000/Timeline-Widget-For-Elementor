<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;

class TWE_Timeline_Widget extends Widget_Base {

    public function get_name() {
        return 'twe_timeline';
    }

    public function get_title() {
        return esc_html__( 'Timeline', 'timeline-widget-elementor' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_keywords() {
        return [ 'timeline', 'history', 'events', 'roadmap', 'steps' ];
    }

    protected function register_controls() {

        // ===================== CONTENT TAB =====================

        $this->start_controls_section(
            'section_timeline_items',
            [
                'label' => esc_html__( 'Timeline Items', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_date',
            [
                'label'       => esc_html__( 'Date / Label', 'timeline-widget-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '2024', 'timeline-widget-elementor' ),
                'placeholder' => esc_html__( 'e.g. January 2024', 'timeline-widget-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label'       => esc_html__( 'Title', 'timeline-widget-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Milestone Title', 'timeline-widget-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label'   => esc_html__( 'Description', 'timeline-widget-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 4,
                'default' => esc_html__( 'Describe this milestone or event in detail. What happened? Why does it matter?', 'timeline-widget-elementor' ),
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label'   => esc_html__( 'Icon', 'timeline-widget-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'item_accent_color',
            [
                'label'   => esc_html__( 'Accent Color', 'timeline-widget-elementor' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '',
            ]
        );

        $this->add_control(
            'timeline_items',
            [
                'label'       => esc_html__( 'Items', 'timeline-widget-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'item_date'        => esc_html__( '2022', 'timeline-widget-elementor' ),
                        'item_title'       => esc_html__( 'Company Founded', 'timeline-widget-elementor' ),
                        'item_description' => esc_html__( 'We started with a big idea and a small team, determined to make a difference in the industry.', 'timeline-widget-elementor' ),
                        'item_icon'        => [ 'value' => 'fas fa-rocket', 'library' => 'fa-solid' ],
                    ],
                    [
                        'item_date'        => esc_html__( '2023', 'timeline-widget-elementor' ),
                        'item_title'       => esc_html__( 'First Major Product Launch', 'timeline-widget-elementor' ),
                        'item_description' => esc_html__( 'Our flagship product hit the market and received incredible feedback from early adopters worldwide.', 'timeline-widget-elementor' ),
                        'item_icon'        => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ],
                    ],
                    [
                        'item_date'        => esc_html__( '2024', 'timeline-widget-elementor' ),
                        'item_title'       => esc_html__( 'Global Expansion', 'timeline-widget-elementor' ),
                        'item_description' => esc_html__( 'We expanded our reach to over 30 countries, building partnerships and growing our community.', 'timeline-widget-elementor' ),
                        'item_icon'        => [ 'value' => 'fas fa-globe', 'library' => 'fa-solid' ],
                    ],
                    [
                        'item_date'        => esc_html__( '2025', 'timeline-widget-elementor' ),
                        'item_title'       => esc_html__( 'Award-Winning Innovation', 'timeline-widget-elementor' ),
                        'item_description' => esc_html__( 'Recognised as a leader in innovation, receiving multiple industry awards for our breakthrough technology.', 'timeline-widget-elementor' ),
                        'item_icon'        => [ 'value' => 'fas fa-trophy', 'library' => 'fa-solid' ],
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();

        // ===================== LAYOUT SECTION =====================

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Layout', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => esc_html__( 'Layout Style', 'timeline-widget-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'      => esc_html__( 'Icon Left, Content Right', 'timeline-widget-elementor' ),
                    'alternate' => esc_html__( 'Alternating (Zigzag)', 'timeline-widget-elementor' ),
                    'center'    => esc_html__( 'Center Line', 'timeline-widget-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'show_date_badge',
            [
                'label'        => esc_html__( 'Show Date Badge', 'timeline-widget-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'timeline-widget-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'timeline-widget-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'animate_on_scroll',
            [
                'label'        => esc_html__( 'Animate on Scroll', 'timeline-widget-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'timeline-widget-elementor' ),
                'label_off'    => esc_html__( 'No', 'timeline-widget-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        // ===================== STYLE TAB – LINE =====================

        $this->start_controls_section(
            'section_style_line',
            [
                'label' => esc_html__( 'Timeline Line', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label'     => esc_html__( 'Line Color', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .twe-timeline::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .twe-timeline-alternate::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .twe-timeline-center .twe-line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'line_width',
            [
                'label'     => esc_html__( 'Line Width (px)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
                'default'   => [ 'size' => 2, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .twe-timeline::before'           => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .twe-timeline-alternate::before' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .twe-timeline-center .twe-line'  => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .twe-line-fill'                  => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'line_fill_color_start',
            [
                'label'     => esc_html__( 'Fill Color (Start)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#4f46e5',
                'selectors' => [
                    '{{WRAPPER}} .twe-line-fill' => 'background: linear-gradient(to bottom, {{VALUE}}, var(--twe-fill-end, #7c3aed));',
                ],
            ]
        );

        $this->add_control(
            'line_fill_color_end',
            [
                'label'     => esc_html__( 'Fill Color (End)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .twe-line-fill' => 'background: linear-gradient(to bottom, var(--twe-fill-start, #4f46e5), {{VALUE}});',
                ],
            ]
        );

        $this->end_controls_section();

        // ===================== STYLE TAB – ICON =====================

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon / Marker', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label'     => esc_html__( 'Icon Size (px)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
                'default'   => [ 'size' => 16, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .twe-icon i, {{WRAPPER}} .twe-alt-icon i, {{WRAPPER}} .twe-center-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .twe-icon svg, {{WRAPPER}} .twe-alt-icon svg, {{WRAPPER}} .twe-center-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_marker_size',
            [
                'label'     => esc_html__( 'Marker Circle Size (px)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 30, 'max' => 80 ] ],
                'default'   => [ 'size' => 48, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .twe-icon, {{WRAPPER}} .twe-alt-icon, {{WRAPPER}} .twe-center-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .twe-icon i, {{WRAPPER}} .twe-alt-icon i, {{WRAPPER}} .twe-center-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .twe-icon svg, {{WRAPPER}} .twe-alt-icon svg, {{WRAPPER}} .twe-center-icon svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    '{{WRAPPER}} .twe-icon svg *, {{WRAPPER}} .twe-alt-icon svg *, {{WRAPPER}} .twe-center-icon svg *' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label'     => esc_html__( 'Icon Background', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#4f46e5',
                'selectors' => [
                    '{{WRAPPER}} .twe-icon, {{WRAPPER}} .twe-alt-icon, {{WRAPPER}} .twe-center-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'timeline-widget-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => 50, 'right' => 50, 'bottom' => 50, 'left' => 50, 'unit' => '%', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .twe-icon, {{WRAPPER}} .twe-alt-icon, {{WRAPPER}} .twe-center-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ===================== STYLE TAB – CARD =====================

        $this->start_controls_section(
            'section_style_card',
            [
                'label' => esc_html__( 'Content Card', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label'     => esc_html__( 'Card Background', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .twe-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e7eb',
                'selectors' => [
                    '{{WRAPPER}} .twe-card' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'timeline-widget-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => 12, 'right' => 12, 'bottom' => 12, 'left' => 12, 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .twe-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .twe-card',
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label'      => esc_html__( 'Padding', 'timeline-widget-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [ 'top' => 20, 'right' => 24, 'bottom' => 20, 'left' => 24, 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .twe-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ===================== STYLE TAB – TYPOGRAPHY =====================

        $this->start_controls_section(
            'section_style_typography',
            [
                'label' => esc_html__( 'Typography', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__( 'Date Color', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#4f46e5',
                'selectors' => [
                    '{{WRAPPER}} .twe-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_typography',
                'label'    => esc_html__( 'Date Typography', 'timeline-widget-elementor' ),
                'selector' => '{{WRAPPER}} .twe-date',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .twe-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__( 'Title Typography', 'timeline-widget-elementor' ),
                'selector' => '{{WRAPPER}} .twe-title',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Description Color', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .twe-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => esc_html__( 'Description Typography', 'timeline-widget-elementor' ),
                'selector' => '{{WRAPPER}} .twe-description',
            ]
        );

        $this->end_controls_section();

        // ===================== STYLE TAB – SPACING =====================

        $this->start_controls_section(
            'section_style_spacing',
            [
                'label' => esc_html__( 'Spacing', 'timeline-widget-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_spacing',
            [
                'label'     => esc_html__( 'Space Between Items (px)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
                'default'   => [ 'size' => 36, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .twe-item:not(:last-child)'     => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .twe-alt-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .twe-center-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_gap',
            [
                'label'     => esc_html__( 'Icon to Card Gap (px)', 'timeline-widget-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
                'default'   => [ 'size' => 20, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .twe-item' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = $settings['timeline_items'];
        $layout   = $settings['layout'];
        $animate  = $settings['animate_on_scroll'] === 'yes' ? 'twe-animate' : '';

        if ( empty( $items ) ) {
            return;
        }

        $wrapper_class = 'twe-timeline-wrapper';

        if ( $layout === 'alternate' ) {
            $wrapper_class .= ' twe-timeline-alternate-wrapper';
        } elseif ( $layout === 'center' ) {
            $wrapper_class .= ' twe-timeline-center-wrapper';
        }
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>" data-animate="<?php echo esc_attr( $settings['animate_on_scroll'] ); ?>">

            <?php if ( $layout === 'left' ) : ?>
                <div class="twe-timeline">
                    <?php foreach ( $items as $index => $item ) :
                        $icon_style = '';
                        if ( ! empty( $item['item_accent_color'] ) ) {
                            $icon_style = 'style="background-color:' . esc_attr( $item['item_accent_color'] ) . ';"';
                        }
                    ?>
                        <div class="twe-item <?php echo esc_attr( $animate ); ?>" data-delay="<?php echo esc_attr( $index * 100 ); ?>">
                            <div class="twe-icon" <?php echo $icon_style; ?>>
                                <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </div>
                            <div class="twe-card">
                                <?php if ( $settings['show_date_badge'] === 'yes' && ! empty( $item['item_date'] ) ) : ?>
                                    <div class="twe-date"><?php echo esc_html( $item['item_date'] ); ?></div>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['item_title'] ) ) : ?>
                                    <h4 class="twe-title"><?php echo esc_html( $item['item_title'] ); ?></h4>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['item_description'] ) ) : ?>
                                    <p class="twe-description"><?php echo wp_kses_post( $item['item_description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ( $layout === 'alternate' ) : ?>
                <div class="twe-timeline-alternate">
                    <?php foreach ( $items as $index => $item ) :
                        $side = ( $index % 2 === 0 ) ? 'twe-left' : 'twe-right';
                        $icon_style = '';
                        if ( ! empty( $item['item_accent_color'] ) ) {
                            $icon_style = 'style="background-color:' . esc_attr( $item['item_accent_color'] ) . ';"';
                        }
                    ?>
                        <div class="twe-alt-item <?php echo esc_attr( $side ); ?> <?php echo esc_attr( $animate ); ?>" data-delay="<?php echo esc_attr( $index * 100 ); ?>">
                            <div class="twe-alt-icon" <?php echo $icon_style; ?>>
                                <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </div>
                            <div class="twe-card">
                                <?php if ( $settings['show_date_badge'] === 'yes' && ! empty( $item['item_date'] ) ) : ?>
                                    <div class="twe-date"><?php echo esc_html( $item['item_date'] ); ?></div>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['item_title'] ) ) : ?>
                                    <h4 class="twe-title"><?php echo esc_html( $item['item_title'] ); ?></h4>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['item_description'] ) ) : ?>
                                    <p class="twe-description"><?php echo wp_kses_post( $item['item_description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php elseif ( $layout === 'center' ) : ?>
                <div class="twe-timeline-center">
                    <div class="twe-line"></div>
                    <?php foreach ( $items as $index => $item ) :
                        $icon_style = '';
                        if ( ! empty( $item['item_accent_color'] ) ) {
                            $icon_style = 'style="background-color:' . esc_attr( $item['item_accent_color'] ) . ';"';
                        }
                    ?>
                        <div class="twe-center-item <?php echo esc_attr( $animate ); ?>" data-delay="<?php echo esc_attr( $index * 100 ); ?>">
                            <div class="twe-center-icon" <?php echo $icon_style; ?>>
                                <?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </div>
                            <div class="twe-card twe-center-card">
                                <?php if ( $settings['show_date_badge'] === 'yes' && ! empty( $item['item_date'] ) ) : ?>
                                    <div class="twe-date"><?php echo esc_html( $item['item_date'] ); ?></div>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['item_title'] ) ) : ?>
                                    <h4 class="twe-title"><?php echo esc_html( $item['item_title'] ); ?></h4>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['item_description'] ) ) : ?>
                                    <p class="twe-description"><?php echo wp_kses_post( $item['item_description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var items = settings.timeline_items;
        var layout = settings.layout;
        var animate = settings.animate_on_scroll === 'yes' ? 'twe-animate' : '';
        if ( ! items.length ) return;
        #>

        <div class="twe-timeline-wrapper" data-animate="{{ settings.animate_on_scroll }}">
            <# if ( layout === 'left' ) { #>
            <div class="twe-timeline">
                <# _.each( items, function( item, index ) {
                    var iconStyle = item.item_accent_color ? 'style="background-color:' + item.item_accent_color + ';"' : '';
                #>
                    <div class="twe-item {{ animate }}" data-delay="{{ index * 100 }}">
                        <div class="twe-icon" {{{ iconStyle }}}>
                            <# var iconHTML = elementor.helpers.renderIcon( view, item.item_icon, {'aria-hidden': true}, 'i', 'object' ); if( iconHTML && iconHTML.rendered ) { #>{{{ iconHTML.value }}}<# } #>
                        </div>
                        <div class="twe-card">
                            <# if ( settings.show_date_badge === 'yes' && item.item_date ) { #><div class="twe-date">{{ item.item_date }}</div><# } #>
                            <# if ( item.item_title ) { #><h4 class="twe-title">{{ item.item_title }}</h4><# } #>
                            <# if ( item.item_description ) { #><p class="twe-description">{{ item.item_description }}</p><# } #>
                        </div>
                    </div>
                <# }); #>
            </div>
            <# } #>
        </div>
        <?php
    }
}
