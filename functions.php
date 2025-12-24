<?php
/**
 * Backbone SEO LLMO Child Theme Functions
 *
 * @package Backbone_SEO_LLMO_Child
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * 親テーマと子テーマのスタイルをエンキュー
 *
 * IMPORTANT: 子テーマのスタイルは親テーマのスタイルの後に読み込む必要があります
 */
function backbone_child_enqueue_styles() {
    // フロントエンドキャッシュバスティング設定を取得
    $cache_busting_frontend = get_theme_mod('enable_cache_busting_frontend', false);

    // 親テーマのスタイル
    wp_enqueue_style(
        'backbone-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        backbone_get_file_version('/style.css', $cache_busting_frontend)
    );

    // 子テーマのスタイル（親テーマのスタイルに依存）
    wp_enqueue_style(
        'backbone-child-style',
        get_stylesheet_uri(),
        array('backbone-parent-style'),
        backbone_child_get_file_version('/style.css', $cache_busting_frontend)
    );
}
add_action('wp_enqueue_scripts', 'backbone_child_enqueue_styles', 15);

/**
 * 子テーマの翻訳ファイルを読み込み
 */
function backbone_child_load_textdomain() {
    load_child_theme_textdomain('backbone-seo-llmo-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'backbone_child_load_textdomain');

/**
 * =============================================================================
 * カスタマイズ例
 * =============================================================================
 *
 * 以下は子テーマでよく使うカスタマイズ例です。
 * 必要に応じてコメントを外して使用してください。
 */

/**
 * 例1: カスタムJavaScriptを追加
 *
 * function backbone_child_enqueue_scripts() {
 *     wp_enqueue_script(
 *         'backbone-child-custom-script',
 *         get_stylesheet_directory_uri() . '/js/custom.js',
 *         array('jquery'),
 *         wp_get_theme()->get('Version'),
 *         true
 *     );
 * }
 * add_action('wp_enqueue_scripts', 'backbone_child_enqueue_scripts', 20);
 */

/**
 * 例2: 新しいウィジェットエリアを追加
 *
 * function backbone_child_widgets_init() {
 *     register_sidebar(array(
 *         'name'          => __('Custom Widget Area', 'backbone-seo-llmo-child'),
 *         'id'            => 'custom-widget-area',
 *         'description'   => __('子テーマのカスタムウィジェットエリア', 'backbone-seo-llmo-child'),
 *         'before_widget' => '<div id="%1$s" class="widget %2$s">',
 *         'after_widget'  => '</div>',
 *         'before_title'  => '<h2 class="widget-title">',
 *         'after_title'   => '</h2>',
 *     ));
 * }
 * add_action('widgets_init', 'backbone_child_widgets_init');
 */

/**
 * 例3: カスタム投稿タイプを追加
 *
 * function backbone_child_register_post_types() {
 *     register_post_type('portfolio', array(
 *         'labels' => array(
 *             'name'               => __('Portfolio', 'backbone-seo-llmo-child'),
 *             'singular_name'      => __('Portfolio Item', 'backbone-seo-llmo-child'),
 *         ),
 *         'public'       => true,
 *         'has_archive'  => true,
 *         'show_in_rest' => true,
 *         'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
 *     ));
 * }
 * add_action('init', 'backbone_child_register_post_types');
 */

/**
 * 例4: 抜粋文の長さを変更
 *
 * function backbone_child_excerpt_length($length) {
 *     return 30; // デフォルトは55文字
 * }
 * add_filter('excerpt_length', 'backbone_child_excerpt_length');
 */

/**
 * 例5: カスタムフックを追加（親テーマのテンプレートで使用）
 *
 * function backbone_child_custom_content() {
 *     echo '<div class="custom-content">カスタムコンテンツ</div>';
 * }
 * add_action('backbone_before_content', 'backbone_child_custom_content');
 */

/**
 * 例6: 親テーマの関数を上書き（プラガブル関数の場合）
 *
 * if (!function_exists('backbone_custom_function')) {
 *     function backbone_custom_function() {
 *         // カスタム実装
 *     }
 * }
 */

/**
 * 例7: アイキャッチ画像のサイズを追加
 *
 * function backbone_child_image_sizes() {
 *     add_image_size('custom-large', 1200, 630, true); // 1200x630px（トリミング有効）
 *     add_image_size('custom-medium', 800, 600, false); // 800x600px（トリミング無効）
 * }
 * add_action('after_setup_theme', 'backbone_child_image_sizes');
 */

/**
 * =============================================================================
 * 管理画面にマニュアルページを追加
 * =============================================================================
 */

/**
 * 子テーママニュアルページを追加
 */
function backbone_child_add_manual_page() {
    add_theme_page(
        __('子テーママニュアル', 'backbone-seo-llmo-child'),
        __('テーママニュアル', 'backbone-seo-llmo-child'),
        'edit_theme_options',
        'backbone-child-manual',
        'backbone_child_manual_page_content'
    );
}
add_action('admin_menu', 'backbone_child_add_manual_page');

/**
 * マニュアルページの内容を出力
 */
function backbone_child_manual_page_content() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2>子テーマについて</h2>
            <p>
                子テーマは親テーマの機能を継承しながら、カスタマイズを安全に行うための仕組みです。<br>
                親テーマを更新してもカスタマイズが消えないため、安心してカスタマイズできます。
            </p>
        </div>

        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2>メリット</h2>
            <ul style="list-style: disc; padding-left: 20px;">
                <li><strong>安全な更新</strong>: 親テーマを更新してもカスタマイズが消えない</li>
                <li><strong>簡単なカスタマイズ</strong>: 必要なファイルだけを編集すればOK</li>
                <li><strong>元に戻せる</strong>: 子テーマを無効化すれば元の状態に戻る</li>
                <li><strong>学習に最適</strong>: 親テーマのコードを参考にしながら学べる</li>
            </ul>
        </div>

        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2>カスタマイズ方法</h2>

            <h3>1. CSSをカスタマイズ</h3>
            <p><code>style.css</code> にカスタムCSSを追加します。</p>
            <pre style="background: #f5f5f5; padding: 10px; border-left: 4px solid #0073aa;">/* ヘッダーの背景色を変更 */
.site-header {
    background: #2c3e50 !important;
}

/* リンクの色を変更 */
a {
    color: #e74c3c;
}</pre>

            <h3>2. PHPをカスタマイズ</h3>
            <p><code>functions.php</code> にカスタム関数を追加します。</p>
            <pre style="background: #f5f5f5; padding: 10px; border-left: 4px solid #0073aa;">// 抜粋文の長さを変更
function my_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'my_excerpt_length');</pre>

            <h3>3. テンプレートファイルをカスタマイズ</h3>
            <p>親テーマのテンプレートファイルを子テーマにコピーして編集します。</p>
            <pre style="background: #f5f5f5; padding: 10px; border-left: 4px solid #0073aa;"># 例: header.php をカスタマイズ
cp ../backbone-seo-llmo/header.php ./header.php
# header.php を編集</pre>
            <p><strong>重要:</strong> 必要なファイルだけをコピーしてください。全ファイルをコピーする必要はありません。</p>
        </div>

        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2>よくある質問</h2>

            <h3>Q1. 子テーマに全ファイルをコピーする必要がありますか？</h3>
            <p><strong>A.</strong> いいえ！必要ありません。カスタマイズしたいファイルだけをコピーしてください。</p>

            <h3>Q2. 親テーマを更新したら子テーマの設定は消えますか？</h3>
            <p><strong>A.</strong> いいえ、消えません。それが子テーマの最大のメリットです。</p>

            <h3>Q3. 子テーマのファイルが優先されますか？</h3>
            <p><strong>A.</strong> はい。同じ名前のファイルがある場合、子テーマのファイルが優先されます。</p>

            <h3>Q4. functions.php は上書きされますか？</h3>
            <p><strong>A.</strong> いいえ。<code>functions.php</code> だけは特別で、親と子の両方が実行されます。</p>

            <h3>Q5. カスタマイザーの設定はどうなりますか？</h3>
            <p><strong>A.</strong> カスタマイザーの設定は親テーマと子テーマで共有されます。</p>
        </div>

        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2>ファイル構成</h2>
            <p>この子テーマには以下のファイルが含まれています：</p>
            <pre style="background: #f5f5f5; padding: 10px; border-left: 4px solid #0073aa;">backbone-seo-llmo-child/
├── style.css        # 必須: テーマ情報とカスタムCSS
├── functions.php    # 推奨: カスタム関数とスタイルのエンキュー
├── readme.txt       # WordPress標準のマニュアル
└── README.md        # 詳細なドキュメント（GitHub用）</pre>
        </div>

        <div class="card" style="max-width: 100%; margin-top: 20px;">
            <h2>参考リンク</h2>
            <ul style="list-style: disc; padding-left: 20px;">
                <li><a href="https://wpdocs.osdn.jp/%E5%AD%90%E3%83%86%E3%83%BC%E3%83%9E" target="_blank">WordPress Codex: 子テーマ</a></li>
                <li><a href="https://github.com/TsuyoshiKashiwazaki/wp-theme-backbone-seo-llmo" target="_blank">親テーマ: Backbone SEO LLMO (GitHub)</a></li>
            </ul>
        </div>

        <div class="card" style="max-width: 100%; margin-top: 20px; background: #fff3cd; border-left: 4px solid #ffc107;">
            <h2>ヒント</h2>
            <p>
                <code>functions.php</code> にはよく使うカスタマイズ例がコメントで記載されています。<br>
                必要に応じてコメントを外して使用してください。
            </p>
        </div>
    </div>
    <?php
}

/**
 * =============================================================================
 * 以下にあなたのカスタム関数を記述してください
 * =============================================================================
 */

/**
 * 子テーマ用ファイルバージョン取得ヘルパー関数
 *
 * @param string $relative_path 相対パス
 * @param bool $cache_busting キャッシュバスティング有効フラグ
 * @return string バージョン文字列
 */
function backbone_child_get_file_version($relative_path, $cache_busting) {
    if ($cache_busting) {
        return current_time('YmdHis');
    } else {
        $full_path = get_stylesheet_directory() . $relative_path;
        return file_exists($full_path) ? filemtime($full_path) : time();
    }
}
