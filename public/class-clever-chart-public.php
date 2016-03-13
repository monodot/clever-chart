<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://monodot.co.uk
 * @since      1.0.0
 *
 * @package    Clever_Chart
 * @subpackage Clever_Chart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Clever_Chart
 * @subpackage Clever_Chart/public
 * @author     Tom Donohue <tom@example.com>
 */
class Clever_Chart_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Clever_Chart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Clever_Chart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/clever-chart-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Clever_Chart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Clever_Chart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/clever-chart-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * A single series stacked bar chart.
	 *
	 * @since    1.0.0
	 */
	public function shortcode_single_stack($atts) {

        extract(shortcode_atts(array(
			'data' => $data,
			'prefix' => $prefix,
			'suffix' => $suffix), $atts));
			
            "category" => "",
            "num"      => 5
            ), $atts));
        $cat = strtolower($category);
        $args = array(
            'posts_per_page'   => $num,
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'cat'              => $cat);

		
		$colours = array('#072A24', '#748F70', '#B0947F', '#C39D9F', '#E2CAED');
		$colours = array('#E2C044', '#9FB1BC', '#6E8898', '#2E5266', '#D3D0CB'); //heritage
		
		$data = array('BP', '2.5', 'Shell', '2.2', 'Starbucks', '1.8', 'Facebook', '0.9', 'WHSmith', '0.4');
		$prefix = "&pound;";
		$suffix = "bn";
		
		if (count($data) % 2 != 0)
			die('Not an even number of data points');
		
		/* First calculate the total */
		$total = 0;
		$numbers = array();
		for ($i = 0; $i < count($data); $i++) {
			if ($i % 2 == 0) {
				$labels[] = $data[$i]; //add label to labels array
			} else {
				$floatval = floatval($data[$i]); //parse the number to a float
				$total += $floatval; //add to total
				$numbers[] = $floatval;
			}
			
			// TODO $points[] = ...
			// TODO $results[] = ...
		}
		
		if ($total == 0)
			die('Total is zero');
		
		/* Now build up the output array */
		for ($i = 0; $i < count($numbers); $i++) {
			$points[] = ($numbers[$i] / $total) * 100; //percentage width
			$points[] = $colours[$i]; //colour
			$points[] = $labels[$i]; //label
			$points[] = $prefix . $numbers[$i] . $suffix; //numeric value
		}
		
		$template = '
			<figure class="clever-chart-container">
				<div class="clever-chart-single-stack">
					<div class="clever-chart-point" style="width: %1$s%%; background-color: %2$s; color: %2$s" title="TODO">
						<div class="clever-chart-point-label" style="border-color: %2$s">%3$s</div>
					</div>
					<div class="clever-chart-point" style="width: %5$s%%; background-color: %6$s; color: %6$s" title="TODO">
						<div class="clever-chart-point-label" style="border-color: %6$s">%7$s</div>
					</div>
					<div class="clever-chart-point" style="width: %9$s%%; background-color: %10$s; color: %10$s" title="TODO">
						<div class="clever-chart-point-label" style="border-color: %10$s">%11$s</div>
					</div>
					<div class="clever-chart-point" style="width: %13$s%%; background-color: %14$s; color: %14$s" title="TODO">
						<div class="clever-chart-point-label" style="border-color: %14$s">%15$s</div>
					</div>
				</div>

				<ul class="clever-chart-results clever-chart-clearfix">
					<li><div class="clever-chart-result" style="border-color: %2$s"><span class="clever-chart-result-label" style="color: %2$s">%3$s</span> - %4$s</div></li>
					<li><div class="clever-chart-result" style="border-color: %6$s"><span class="clever-chart-result-label" style="color: %6$s">%7$s</span> - %8$s</div></li>
					<li><div class="clever-chart-result" style="border-color: %10$s"><span class="clever-chart-result-label" style="color: %10$s">%11$s</span> - %12$s</div></li>
					<li><div class="clever-chart-result" style="border-color: %14$s"><span class="clever-chart-result-label" style="color: %14$s">%15$s</span> - %16$s</div></li>
				</ul>
			</figure>';
			
		$output = vsprintf($template, $points);
		
		return $output;

	}

}
