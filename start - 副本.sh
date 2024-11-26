#!/bin/bash
# 定义微服务项目的目录
SERVICES=(
    "./api-gateway"
    "./order-srv"
    "./user-srv"
    "./file-srv"
    "./task-srv"
)
# 启动每个微服务
for SERVICE in "${SERVICES[@]}"; do
    echo "Starting service in $SERVICE..."
    # 启动服务，并将输出重定向到日志文件 () 代表子shell
    (cd "$SERVICE" && php bin/hyperf.php start > service.log 2>&1 &)
    echo "Service started in background: $SERVICE"
done

echo "All services started."