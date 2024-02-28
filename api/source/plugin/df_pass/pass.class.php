<?php

/**
 *      This is NOT a freeware, use is subject to license terms
 *      应用名称: 注册显示隐藏密码 x1.1
 *      下载地址: https://addon.dismall.com/plugins/df_pass.html
 *      应用开发者: 编号9527
 *      开发者QQ: 7133017
 *      更新日期: 202402281225
 *      授权域名: 192.168.0.107
 *      授权码: 2024022804ODSxxzsSrY
 *      未经应用程序开发者/所有者的书面许可，不得进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等
 */

/**
 *	[注册密码隐藏显示(df_pass.{modulename})] (C)2023-2099 Powered by admxn.com.
 *	Version: x1.1
 *	Date: 2023年12月14日 10:40:32
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_df_pass_member {
	function register_top() {
	    global $_G;
		if ($_G['cache']['plugin']['df_pass']['css']) {
			$cssCode = $_G['cache']['plugin']['df_pass']['css'];
		} else {
			$cssCode = <<<CSS
			<style>
			    .fx-eye, .fx-eye-slash {
			        position: absolute;
			        width: 18px;
			        height: 18px;
			        margin-left: -25px;
			        background: url(./source/plugin/df_pass/template/svg/comiis_ico_view.svg) no-repeat center 3px;
			        background-size: 18px;
			        cursor: pointer;
			    }
			    .fx-eye-slash {
			        background: url(./source/plugin/df_pass/template/svg/comiis_e_hide.svg) no-repeat center 3px;
			        background-size: 18px;
			    }
			</style>
CSS;
		}
		return $cssCode;
	}
	
	function register_bottom() {
        global $_G;
		
		$ahide = $_G['cache']['plugin']['df_pass']['hide'];
		$abut = $_G['cache']['plugin']['df_pass']['but'];

        $reg_js = <<<EOF
        <script type="text/javascript">
			var hides = '{$ahide}';
			var buts = '{$abut}';
			
			// 查找id为registerform内的所有type为password的input元素
			const passwordInputs = document.querySelectorAll('#registerform input[type="password"]');
	
		   if (hides == 1) {
				// 找到第二个密码框所在的div并将其隐藏
				let parentDiv = passwordInputs[1].parentNode;
				while (parentDiv.tagName !== 'DIV') {
				  parentDiv = parentDiv.parentNode;
				}
				parentDiv.style.display = 'none';
			   
				// 监听第一个密码框的输入事件
				passwordInputs[0].addEventListener('input', function() {
				  // 将第一个密码框的值同步到第二个密码框
				  passwordInputs[1].value = passwordInputs[0].value;
				});
			}
		   
		   if (buts == 1) {
				// 显示/隐藏密码按钮
				const buttonHtml = '<span id="showPasswordButton" class="fx-eye"></span>';
				passwordInputs[0].insertAdjacentHTML('afterend', buttonHtml);
		
				const showPasswordButton = document.getElementById('showPasswordButton');
			   
				let isPasswordVisible = false;
			   
				showPasswordButton.addEventListener('click', function() {
				  isPasswordVisible = !isPasswordVisible;
			   
				  if (isPasswordVisible) {
					// 切换为文本类型，密码可见
					passwordInputs[0].type = 'text';
							showPasswordButton.classList.remove('fx-eye');
							showPasswordButton.classList.add('fx-eye-slash');
				  } else {
					// 切换回密码类型，密码隐藏
					passwordInputs[0].type = 'password';
							showPasswordButton.classList.remove('fx-eye-slash');
							showPasswordButton.classList.add('fx-eye');
				  }
				});
			}
        </script>
EOF;
		return $reg_js;
    }
}