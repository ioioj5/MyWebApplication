# 说明

> 本项目的目的是解决中小型电商在不同的场景中出现的各种问题

# 场景

1. 秒杀/抢购
    > 秒杀/抢购这种场景下, 主要容易出现的问题是抢单(下单). 而抢单主要的问题集中在两个方面:高并发与超卖.

    - 高并发
        > 短时间内, 流量的急剧增加造成服务器压力急剧上升.

        解决方案: 扩容与限流.

        扩充: 从架构从面, 拆分服务, 独立部署. 如: 可以将系统拆分成订单服务、商品服务、用户服务等,每项服务部署到独立的服务器上,隔离服务对整个系统的影响,提高系统的稳定性, 不会造成因为某个服务出现故障导致整个系统的不可用.

        限流: 分为前后端. 前端: 静态化与CDN; 后端: 控制访问频率,尽量阻止访问直抵数据库层

    - 超卖
        > 主要指的是下单数超出了库存的数量

        解决方案: 队列

# 配置

- 所需服务

    PHP5.6 + MySQL5.6 + Nginx/Apache2.4 + Redis

- 脚本

    ```
    $ ./yii goods/init # 初始化商品数据
    $ ./yii redis/push # 初始化商品库存
    $ ./yii redis/makr-order # 处理订单队列
    $ ./yii order/un-paid-order # 处理未支付订单
    ```
    
# 安装

1. clone代码

```angular2html
$ git clone git@github.com:ioioj5/MyWebApplication.git
```

2. 配置虚拟站点
>把根目录中的backend以及frontend单独配置虚拟站点.

```angular2html
1. backend: backend.local
2. frontend: frontend.local
```

3. 导入./doc/db/*.sql
> 先导入主表my.local.sql, 然后再导入其他表