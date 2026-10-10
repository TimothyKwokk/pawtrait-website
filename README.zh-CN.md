# pawtrait-website
Pawtrait 个性化宠物服装与礼品网站

[English](README.md) | 简体中文

# Pawtrait — 完整网站源代码

快照日期：2026 年 9 月 24 日。所包含的网站文件保持原样。

## 目录结构

```text
pawtrait/
  README.md
  .openai/hosting.json     现有 Sites 部署配置
  dist/                   完整静态网站；发布此文件夹
    index.html            首页
    about.html            关于我们及宠物模特 QQ 的介绍
    services.html         服务、流程与常见问题
    listings.html         产品系列与筛选功能
    contact.html          联系表单与地图
    privacy.html          隐私政策
    terms.html            服务条款
    shipping-returns.html 配送与退换货
    style.css             共用样式与响应式布局
    app.js                菜单、筛选、个性化定制与草稿下载
    images/               QQ 照片及产品／参考图片
```

## 打开或运行

解压 ZIP 文件。在浏览器中打开 `dist/index.html`，即可进行基本的本地浏览。

如果已安装 Python 3，可在 `pawtrait` 文件夹中运行以下命令，启动本地网站预览：

```sh
python3 -m http.server 8000 --directory dist
```

然后打开 http://localhost:8000 。无需运行 `npm install`，也无需构建步骤。

若使用其他静态网站托管服务，请发布 `dist` 文件夹的内容；`.openai` 配置仅适用于现有的 Sites 项目。

## 当前功能

网站包含导航、响应式布局、产品类别筛选、照片预览、定制需求说明下载以及咨询草稿下载功能。上传的照片仅在本地预览。表单不会发送消息。网站目前不包含结账、支付集成、客户数据库或服务端订单处理功能。

政策页面描述的是预览阶段的情况。正式商业上线前，仍需完善公司联系信息及运营政策。

## 外部资源

Google Fonts、嵌入式 OpenStreetMap 地图以及外部社交分享链接需要互联网连接。网站图片已包含在本地文件中。

此压缩包包含网站自行编写的代码与图片资源，不包含托管服务商的软件或第三方服务。不包含任何凭据或 Git 历史记录。
