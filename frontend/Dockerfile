FROM node:20-bullseye

ENV LANG=C.UTF-8 \
    TZ=Asia/Tokyo \
    WORKDIR=/app

WORKDIR ${WORKDIR}

# 必要なパッケージをインストール
RUN apt-get clean && \
    apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y bash tzdata xdg-utils git python3 make g++ && \
    rm -rf /var/lib/apt/lists/*

# package.jsonとpackage-lock.jsonをコピー
COPY package*.json ./

# node_modulesとキャッシュをクリアして再インストール
RUN npm cache clean --force && \
    rm -rf node_modules package-lock.json && \
    npm rebuild && \
    npm i && \
    chmod -R 777 node_modules

# アプリケーションコードをコピー
COPY . .

EXPOSE 5173

# Viteを起動
CMD ["npm", "run", "dev"]