# Codex Project Context

File nay danh rieng cho Codex. Doc file nay truoc khi lam bat ky yeu cau code nao trong project nay.

## Tong Quan

- Day la project WordPress.
- Source de build nam trong `wp-content/src`.
- Theme chinh dang phat trien la `wp-content/themes/paint`.
- Plugin tu phat trien de bo tro theme la `wp-content/plugins/extend-site`.
- Khong can hoi lai cau truc tren moi lan lam viec, tru khi yeu cau moi khong ro nen sua o dau.

## Nguyen Tac Chon Noi Sua

- Sua SCSS, JS, image source: uu tien `wp-content/src`.
- Sua giao dien theme, template, markup, enqueue, hook/filter cua theme: vao `wp-content/themes/paint`.
- Sua logic bo tro theme, custom post type, field, option, Elementor widget, breadcrumb, template routing cua plugin: vao `wp-content/plugins/extend-site`.
- Khong sua truc tiep file build/minified neu co source tuong ung trong `wp-content/src`.
- Khong sua WordPress core trong `wp-admin`, `wp-includes`, hoac cac file `wp-*.php` o root neu khong duoc yeu cau ro.
- Khong sua vendor/dependency trong `wp-content/node_modules`.
- Khong refactor lan man ngoai pham vi yeu cau.

## Build Assets

- Chay lenh tu thu muc `wp-content`.
- Mac dinh khong tu chay build CSS/JS vi user da chay `gulp watch`.
- Chi chay build/watch khi user yeu cau ro hoac can de debug mot loi build cu the.
- Build toan bo asset:

```powershell
npx gulp buildAll
```

- Watch/dev server:

```powershell
npx gulp watchRun
```

- `wp-content/.env` co cau hinh `PROXY`.
- `NODE_ENV=development` dung cho sourcemap/dev workflow.

## Source Map Can Nho

- `wp-content/src/scss/style-theme.scss` build ra CSS theme chung.
- `wp-content/src/scss/templates/*.scss` build ra CSS cho template/page.
- `wp-content/src/scss/post-type/*/**/*.scss` build ra CSS cho tung post type.
- `wp-content/src/scss/elementor-addon/elementor-addon.scss` build ra CSS Elementor addon trong theme.
- `wp-content/src/js/*.js` build ra JS theme.
- `wp-content/src/js/elementor-addon/*.js` build ra JS Elementor addon trong theme.
- `wp-content/src/images/**/*` build ra image assets cua theme.

## SCSS Va Figma CSS

- Khi user dua CSS copy tu Figma, chi xem do la tham chieu visual, khong copy nguyen.
- Chi lay nhung gia tri can thiet: typography, font-size, font-weight, line-height, color, background, border, border-radius, spacing neu dung voi layout hien tai.
- Bo qua cac thu Figma hay sinh thua neu khong that su can: `position: absolute`, toa do `left/top`, width/height co dinh, frame layout, layer order, transform, opacity thua, clip/mask, auto-layout CSS khong phu hop.
- CSS phai duoc viet lai thanh SCSS theo chuan dang co trong `wp-content/src/scss`.
- Uu tien dung bien trong `wp-content/src/scss/variables-site`, vi du `$color-*`, `$background-*`, `$font-*`.
- Truoc khi them style moi, kiem tra class/utility/pattern co san trong SCSS hien co, vi du container/max-width, heading, button, card, grid, spacing, font, color.
- Neu project da co class dung lai phu hop thi uu tien gan class do trong markup thay vi viet lai CSS tuong duong.
- Neu can tao class dung lai cho nhieu section trong cung page/template, tao class rieng co scope ro rang theo page, vi du `.about-container`, thay vi lap lai `max-width`, gutter, margin o tung block.
- Khong lap lai `font-family`, `font-size`, `font-weight`, `line-height`, color neu thua ke tu base/theme/Bootstrap hoac class co san da dap ung dung visual.
- Chi override typography/spacing khi design can khac ro voi mac dinh; override nen nam trong selector component/page hien tai de tranh anh huong rong.
- Neu can them mau/font/spacing dung lai nhieu lan, them bien vao `variables-site` thay vi lap hard-code nhieu noi.
- Giu nesting SCSS vua du, bam theo class/component hien co, tranh tao selector qua sau hoac override bang `!important` neu chua can.
- Responsive phai theo cach project dang to chuc trong SCSS hien co, khong copy breakpoint ngau nhien tu Figma.

## Khi Co Anh Chup Figma

- Dung anh chup Figma de doc visual: layout, hierarchy, spacing, typography, mau sac, background, border, radius, shadow, state.
- Khong copy pixel-perfect mot cach may moc neu khong co design token/spec ro rang.
- Khong doan font-size/spacing tuyet doi qua anh neu khong chac; uu tien uoc luong hop ly theo SCSS/component hien co.
- Neu user dua ca CSS copy tu Figma va anh chup, anh chup dung de kiem tra visual, CSS Figma chi dung de tham khao gia tri can thiet.
- Khi code tu anh, uu tien responsive va cau truc HTML/SCSS san co hon viec dung toa do tuyet doi.
- Neu anh thieu state quan trong nhu mobile, hover, active, error, tu suy luan theo pattern hien co hoac hoi lai neu anh huong lon.

## Theme `paint`

- Entry chinh: `wp-content/themes/paint/functions.php`.
- Theme includes: `wp-content/themes/paint/includes`.
- Theme extension cu/di kem theme: `wp-content/themes/paint/extension`.
- Template files nam truc tiep trong theme va trong `template-parts`, `templates`, `components`.
- Khi sua template, nen tim file PHP lien quan trong theme va file SCSS/JS source tuong ung trong `wp-content/src`.

## Theme Render Va Lay Du Lieu

- Theme `paint` la noi render giao dien chinh: root template nhu `single-*.php`, `archive-*.php`, `taxonomy-*.php`, `page.php`, folder `templates`, `template-parts`, va `components`.
- Page template nam trong `wp-content/themes/paint/templates`, vi du `templates/home.php`, `templates/faq.php`.
- Partial cua page template nam trong `wp-content/themes/paint/templates/parts`, vi du Home page dung `templates/parts/home-page/inc-*.php`.
- Partial chung theo mien giao dien nam trong `wp-content/themes/paint/template-parts`, vi du `header`, `footer`, `product`, `project`, `discover`, `post`.
- Component dung lai nam trong `wp-content/themes/paint/components`.
- Helper theme chinh nam trong `wp-content/themes/paint/includes/theme-function.php`.
- Khi template can lay du lieu Carbon Fields theo tab, uu tien pattern hien co: import class tab field va goi `paint_get_field_tab_data(TabClass::class, $post_id_optional)`.
- Vi du Home page partial dung cac class trong `ExtendSite\Admin\Fields\Pages\Home\*Tab` va goi `paint_get_field_tab_data(...)`.
- Header co the lay field rieng tung page qua `ExtendSite\Admin\Fields\Pages\Default\MenuTab` va `paint_get_field_tab_data(MenuTab::class, $page_id)`.
- Khi can biet key field nao render ra dau, tim class tab field trong plugin `includes/Admin/Fields` truoc, sau do tim `paint_get_field_tab_data` hoac key data tuong ung trong theme.
- Theme hien con nhieu cho lay option cu qua `paint_get_option()` duoc dinh nghia trong `wp-content/themes/paint/extension/theme-option/options.php` va doc tu option key `options`.
- Khong tu y them option moi vao Codestar/theme extension cu neu khong duoc yeu cau; neu can option moi, uu tien Carbon ThemeOptions trong plugin va xac minh helper/cach lay gia tri truoc khi render.
- Khi sua noi lay option hien co, tim theo key option trong ca `wp-content/themes/paint/extension/theme-option/options.php` va `wp-content/plugins/extend-site/includes/Admin/Options` de biet no la option cu hay option moi.

## Plugin `extend-site`

- Entry chinh: `wp-content/plugins/extend-site/extend-site.php`.
- Namespace chinh: `ExtendSite`.
- Autoload map theo namespace trong `wp-content/plugins/extend-site/includes`.
- Plugin boot qua `ExtendSite\Core\Plugin`.
- CPT nam trong `includes/PostType`; danh sach dang load nam trong `PostTypeManager`.
- Admin fields/options nam trong `includes/Admin`.
- Elementor widgets nam trong `includes/ElementorAddon`.
- Breadcrumb module nam trong `includes/Core/Breadcrumb`.
- Template default cua plugin nam trong `wp-content/plugins/extend-site/templates`.
- Theme co the override template plugin bang folder `extend-site` trong theme neu can.

## Custom Post Type

- CPT duoc khai bao trong `wp-content/plugins/extend-site/includes/PostType`.
- Base class chung: `wp-content/plugins/extend-site/includes/PostType/BasePostType.php`.
- Manager load CPT: `wp-content/plugins/extend-site/includes/PostType/PostTypeManager.php`.
- Template loader cho CPT/plugin template: `wp-content/plugins/extend-site/includes/PostType/TemplateLoader.php`.
- CPT hien co dang load trong `PostTypeManager`: `ProductPostType`, `ColorCodePostType`, `ToolPostType`, `ProjectPostType`, `DiscoverPostType`, `FaqPostType`.
- Khi them CPT moi, tao class `{Name}PostType.php` trong `includes/PostType`, ke thua/cung pattern voi CPT hien co, va them class vao mang `$post_types` trong `PostTypeManager`.
- Field/meta cua CPT khong nam trong folder `PostType`; field/meta nam trong `wp-content/plugins/extend-site/includes/Admin/Fields` theo muc `Field, Meta Va Theme Option`.
- Template hien thi cua CPT co the nam trong plugin `wp-content/plugins/extend-site/templates` hoac bi theme override trong `wp-content/themes/paint/extend-site`.

## Field, Meta Va Theme Option

- Project chi dung Carbon Fields cho field/meta/option hien tai.
- Khong dung CMB2 nua; bo qua cac file `*CmbFields.php` khi tim noi sua hoac them field moi, tru khi user yeu cau ro ve migration/legacy.
- Field rieng cho Page theo page template nam trong `wp-content/plugins/extend-site/includes/Admin/Fields/Pages`.
- Manager dang ky field cho page template: `wp-content/plugins/extend-site/includes/Admin/Fields/Pages/PageFieldsManager.php`.
- Field chung cua page default nam trong `Fields/Pages/DefaultFields.php` va cac tab con trong `Fields/Pages/Default`.
- Field cho Home page nam trong `Fields/Pages/HomeFields.php` va cac tab con trong `Fields/Pages/Home`.
- Field cho FAQ page nam trong `Fields/Pages/FaqFields.php` va cac tab con trong `Fields/Pages/Faq`.
- Khi can them field cho page template moi, them class register trong `Fields/Pages`, them tab con neu can, va dang ky class do trong `PageFieldsManager::register()`.
- Field/meta cua custom post type nam theo tung CPT trong `wp-content/plugins/extend-site/includes/Admin/Fields`.
- File tong cho CPT thuong co dang `{PostType}Fields.php`, vi du `ProductFields.php`, `ProjectFields.php`, `ToolFields.php`, `DiscoverFields.php`, `ColorCodeFields.php`.
- Tab field chi tiet cua tung CPT nam trong folder con cung ten, vi du `Fields/Product/ProductInfoTab.php`, `Fields/Project/ProjectGeneralTab.php`.
- Theme options nam trong `wp-content/plugins/extend-site/includes/Admin/Options`.
- File tong dang ky theme options la `wp-content/plugins/extend-site/includes/Admin/Options/ThemeOptions.php`.
- Cac module option rieng nam trong `wp-content/plugins/extend-site/includes/Admin/Options/Modules`, vi du `HeaderOptions.php`, `FooterOptions.php`, `ContactOptions.php`, `PostArchiveOptions.php`, `SinglePostOptions.php`.
- Khi sua template/theme can dung gia tri field, tim key field o cac file tren truoc, roi moi tim noi render trong theme `paint` hoac template override cua plugin.

## Cach Lam Viec Mac Dinh

- Truoc khi sua, doc file lien quan de nam style code hien co.
- Giu style code, naming, indentation, va cach to chuc hien tai.
- Neu thay code cu trong theme va code moi trong plugin cung xu ly mot mien logic, uu tien hoi hoac giai thich ngan vi sao chon noi sua.
- Sau khi sua asset, khong tu chay build neu user khong yeu cau; user dang tu chay watch bang gulp.
- Neu khong chay duoc build/test do thieu dependency, service, hoac loi moi truong, bao ro lenh da thu va blocker.

## Tranh Tac Vu Keo Dai Hoac Treo

- Luon gioi han pham vi doc/tim kiem vao khu vuc lien quan, uu tien `wp-content/src`, `wp-content/themes/paint`, va `wp-content/plugins/extend-site`.
- Khi tim file/text, uu tien `rg`/`rg --files` va loai tru cac thu muc nang neu khong can: `wp-content/node_modules`, `wp-content/uploads`, `vendor`, `.git`, file build/minified.
- Khong chay lenh watch/dev server/build dai han neu user khong yeu cau ro.
- Moi lenh shell nen co timeout hop ly; neu lenh co nguy co chay lau, dat timeout ngan truoc roi tang dan khi can.
- Neu mot lenh/test/build qua 30 giay ma chua co ket qua ro, cap nhat trang thai ngan cho user va neu can thi dung lai de doi huong.
- Khong de session nen hoac tien trinh dai han chay tiep khi ket thuc cau tra loi, tru khi user da yeu cau mo server/watch.
- Neu can quet rong hoac build toan bo de xac minh, noi ro ly do truoc khi lam va chi lam khi that su can cho yeu cau hien tai.
