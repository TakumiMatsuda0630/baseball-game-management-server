<?php

namespace Application\Domain\Stadium\UseCase;

use Application\Domain\Stadium\StadiumFactoryInterface;
use Application\Domain\Stadium\StadiumRepositoryInterface;

class StoreStadiumUseCase
{
    public function __construct(
        private StadiumFactoryInterface $stadiumFactory,
        private StadiumRepositoryInterface $stadiumRepository
    ) {
    }

    /**
     * 球場の登録
     * @param StoreStadiumInput $input
     * @return void
     */
    public function process(StoreStadiumInput $input): void
    {
        try {
            // 入力値の検証
            $stadium = $this->stadiumFactory->createStadium($input->getName());
        } catch (\InvalidArgumentException $e) {
            // 例外をキャッチして適切な処理を行う
            throw $e;
        }
    

        try {
            // 球場を保存
            $this->stadiumRepository->save($stadium);
        } catch (\Exception $e) {
            // 保存に失敗した場合の処理
            throw $e;
        }
        
    }
}